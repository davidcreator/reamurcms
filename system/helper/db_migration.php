<?php
/**
 * Database Migration Helper
 * @package ReamurCMS
 * @version 1.0.0
 * 
 * This file provides functionality for database migrations and schema versioning.
 * It works with the db_schema.php file to manage database changes over time.
 */

/**
 * Check if a migration is needed by comparing the current database version with the schema version
 * 
 * @param \Reamur\System\Library\DB $db The database connection object
 * @return bool True if migration is needed, false otherwise
 */
function rms_check_migration_needed($db) {
    // Check if the schema_version table exists
    $table_exists = false;
    try {
        $query = $db->query("SHOW TABLES LIKE '" . DB_PREFIX . "schema_version'");
        $table_exists = ($query->num_rows > 0);
    } catch (\Exception $e) {
        // Table doesn't exist
        return true;
    }
    
    if (!$table_exists) {
        return true;
    }
    
    // Get the latest applied version from the database
    $query = $db->query("SELECT version FROM " . DB_PREFIX . "schema_version ORDER BY version_id DESC LIMIT 1");
    
    if ($query->num_rows) {
        $current_version = $query->row['version'];
        // Compare with the schema version
        return version_compare(rms_db_schema_version(), $current_version, '>');
    }
    
    return true;
}

/**
 * Apply database migrations based on the schema definition
 * 
 * @param \Reamur\System\Library\DB $db The database connection object
 * @param string $description Optional description of the migration
 * @return array Array with status and message
 */
function rms_apply_migration($db, $description = '') {
    // Initialize result array
    $result = [
        'success' => false,
        'message' => '',
        'details' => []
    ];
    
    try {
        // Load the schema
        if (!function_exists('rms_db_schema')) {
            require_once(DIR_SYSTEM . 'helper/db_schema.php');
        }
        
        $tables = rms_db_schema();
        
        // Start transaction for safer migration
        $db->query("START TRANSACTION");
        
        // Check if schema_version table exists and create it if not
        $query = $db->query("SHOW TABLES LIKE '" . DB_PREFIX . "schema_version'");
        
        if ($query->num_rows == 0) {
            // Create the schema_version table first
            if (isset($tables['rms_schema_version'])) {
                $schema_table = $tables['rms_schema_version'];
                
                $sql = "CREATE TABLE `" . DB_PREFIX . "schema_version` (";
                
                foreach ($schema_table['fields'] as $field) {
                    $sql .= "`" . $field['name'] . "` " . $field['type'];
                    
                    if (!empty($field['not_null'])) {
                        $sql .= " NOT NULL";
                    }
                    
                    if (isset($field['default'])) {
                        // Handle SQL functions and special values without quotes
                        if (rms_is_sql_function($field['default'])) {
                            // Ensure CURRENT_TIMESTAMP is always used without parentheses
                            $default_value = $field['default'];
                            if (strtoupper($default_value) === 'CURRENT_TIMESTAMP()') {
                                $default_value = 'CURRENT_TIMESTAMP';
                            }
                            $sql .= " DEFAULT " . $default_value;
                        } else {
                            $sql .= " DEFAULT '" . $db->escape($field['default']) . "'";
                        }
                    }
                    
                    if (!empty($field['auto_increment'])) {
                        $sql .= " AUTO_INCREMENT";
                    }
                    
                    $sql .= ", ";
                }
                
                // Add primary key
                if (isset($schema_table['primary'])) {
                    $primary_data = [];
                    
                    foreach ($schema_table['primary'] as $primary) {
                        $primary_data[] = "`" . $primary . "`";
                    }
                    
                    $sql .= "PRIMARY KEY (" . implode(",", $primary_data) . ")";
                }
                
                $sql .= ") ENGINE=" . ($schema_table['engine'] ?? DB_ENGINE_INNODB);
                $sql .= " CHARSET=" . ($schema_table['charset'] ?? DB_CHARSET_UTF8MB4);
                $sql .= " COLLATE=" . ($schema_table['collate'] ?? DB_COLLATE_UTF8MB4_GENERAL);
                
                $db->query($sql);
                $result['details'][] = "Created schema_version table";
            }
        }
        
        // Record the migration
        $db->query("INSERT INTO " . DB_PREFIX . "schema_version SET "
            . "version = '" . $db->escape(rms_db_schema_version()) . "', "
            . "description = '" . $db->escape($description) . "', "
            . "applied_at = NOW()");
        
        // Commit the transaction
        $db->query("COMMIT");
        
        $result['success'] = true;
        $result['message'] = 'Migration applied successfully';
        $result['details'][] = "Recorded migration version " . rms_db_schema_version();
        
        return $result;
    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        try {
            $db->query("ROLLBACK");
        } catch (\Exception $rollbackException) {
            // Log rollback failure
            if (defined('DIR_LOGS')) {
                error_log('Migration rollback error: ' . $rollbackException->getMessage(), 3, DIR_LOGS . 'migration_error.log');
            }
        }
        
        // Log the error
        if (defined('DIR_LOGS')) {
            error_log('Migration error: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), 3, DIR_LOGS . 'migration_error.log');
        }
        
        $result['message'] = 'Migration failed: ' . $e->getMessage();
        $result['details'][] = $e->getTraceAsString();
        
        return $result;
    }
}

/**
 * Check if a value is an SQL function that should not be quoted
 * 
 * @param string $value The value to check
 * @return bool True if the value is an SQL function, false otherwise
 */
function rms_is_sql_function($value) {
    // If the value is CURRENT_TIMESTAMP with parentheses, convert it to without parentheses
    // MySQL requires CURRENT_TIMESTAMP without parentheses for DEFAULT values
    if (strtoupper($value) === 'CURRENT_TIMESTAMP()') {
        return true;
    }
    
    $sql_functions = [
        // Date and time functions - support both with and without parentheses
        // Note: MySQL prefers CURRENT_TIMESTAMP without parentheses for DEFAULT values
        '/^(CURRENT_TIMESTAMP|NOW|CURDATE|CURRENT_DATE|CURTIME|CURRENT_TIME)(\(\))?$/i',
        // String functions
        '/^(CONCAT|CONCAT_WS|UPPER|LOWER|TRIM)\(.+\)$/i',
        // Numeric functions
        '/^(ABS|ROUND|FLOOR|CEILING|RAND)\(.+\)$/i',
        // Null value
        '/^NULL$/i'
    ];
    
    foreach ($sql_functions as $pattern) {
        if (preg_match($pattern, $value)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Get migration history
 * 
 * @param \Reamur\System\Library\DB $db The database connection object
 * @param int $limit Optional limit of records to return
 * @return array Migration history records
 */
function rms_get_migration_history($db, $limit = 10) {
    $history = [];
    
    try {
        $query = $db->query("SHOW TABLES LIKE '" . DB_PREFIX . "schema_version'");
        
        if ($query->num_rows) {
            $query = $db->query("SELECT * FROM " . DB_PREFIX . "schema_version ORDER BY version_id DESC LIMIT " . (int)$limit);
            $history = $query->rows;
        }
    } catch (\Exception $e) {
        // Table doesn't exist or other error
    }
    
    return $history;
}