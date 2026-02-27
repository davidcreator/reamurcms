<?php
/**
 * Database Validation Helper
 * @package ReamurCMS
 * @version 1.0.0
 * 
 * This file provides functionality for validating database schema definitions
 * and checking database integrity against the defined schema.
 */

/**
 * Validate the database schema definition for errors or inconsistencies
 * 
 * @return array Array of validation errors, empty if no errors found
 */
function rms_validate_schema_definition() {
    // Load the schema
    if (!function_exists('rms_db_schema')) {
        require_once(DIR_SYSTEM . 'helper/db_schema.php');
    }
    
    $tables = rms_db_schema();
    $errors = [];
    $warnings = [];
    
    // Validate schema version format
    $version = rms_db_schema_version();
    if (!preg_match('/^\d+\.\d+\.\d+$/', $version)) {
        $errors[] = "Schema version '{$version}' does not follow semantic versioning format (x.y.z)";
    }
    
    // Check for duplicate table names (case insensitive)
    $table_names = [];
    foreach ($tables as $table_name => $table) {
        $lower_name = strtolower($table_name);
        if (isset($table_names[$lower_name])) {
            $errors[] = "Duplicate table name '{$table_name}' (conflicts with '{$table_names[$lower_name]}')";
        } else {
            $table_names[$lower_name] = $table_name;
        }
    }
    
    foreach ($tables as $table_name => $table) {
        // Check if table has fields defined
        if (!isset($table['fields']) || !is_array($table['fields']) || empty($table['fields'])) {
            $errors[] = "Table '{$table_name}' has no fields defined";
            continue;
        }
        
        // Check if table has at least one visible column
        $has_visible_column = false;
        foreach ($table['fields'] as $field) {
            if (isset($field['name']) && !empty($field['name'])) {
                $has_visible_column = true;
                break;
            }
        }
        
        if (!$has_visible_column) {
            $errors[] = "Table '{$table_name}' must have at least one visible column";
        }
        
        // Check for duplicate field names within the table
        $field_names = [];
        foreach ($table['fields'] as $field) {
            if (isset($field['name'])) {
                $lower_field_name = strtolower($field['name']);
                if (isset($field_names[$lower_field_name])) {
                    $errors[] = "Duplicate field name '{$field['name']}' in table '{$table_name}'";
                } else {
                    $field_names[$lower_field_name] = $field['name'];
                }
            }
        }
        
        // Check field definitions
        foreach ($table['fields'] as $index => $field) {
            // Check if field has a name
            if (!isset($field['name']) || empty($field['name'])) {
                $errors[] = "Field at index {$index} in table '{$table_name}' has no name";
                continue;
            }
            
            // Check if field has a type
            if (!isset($field['type']) || empty($field['type'])) {
                $errors[] = "Field '{$field['name']}' in table '{$table_name}' has no type";
                continue;
            }
            
            // Check if auto_increment field is also marked as not_null
            if (!empty($field['auto_increment']) && empty($field['not_null'])) {
                $errors[] = "Auto-increment field '{$field['name']}' in table '{$table_name}' must be NOT NULL";
            }
            
            // Check if auto_increment is only used on numeric fields
            if (!empty($field['auto_increment']) && !preg_match('/^(int|bigint|smallint|tinyint|mediumint)/i', $field['type'])) {
                $errors[] = "Auto-increment can only be used on integer fields, but '{$field['name']}' in table '{$table_name}' is of type '{$field['type']}'";
            }
            
            // Check for valid default values
            if (isset($field['default'])) {
                // Check if default value is compatible with field type
                if (!rms_is_sql_function($field['default'])) {
                    if (preg_match('/^(datetime|timestamp)/i', $field['type']) && !preg_match('/^\d{4}-\d{2}-\d{2}(\s\d{2}:\d{2}:\d{2})?$/', $field['default'])) {
                        $warnings[] = "Default value '{$field['default']}' for datetime field '{$field['name']}' in table '{$table_name}' may not be valid";
                    }
                    
                    if (preg_match('/^(int|bigint|smallint|tinyint|mediumint)/i', $field['type']) && !is_numeric($field['default'])) {
                        $warnings[] = "Default value '{$field['default']}' for numeric field '{$field['name']}' in table '{$table_name}' is not numeric";
                    }
                }
            }
        }
        
        // Check primary key
        if (isset($table['primary']) && is_array($table['primary'])) {
            if (empty($table['primary'])) {
                $warnings[] = "Table '{$table_name}' has an empty primary key definition";
            }
            
            foreach ($table['primary'] as $primary_field) {
                $field_exists = false;
                
                foreach ($table['fields'] as $field) {
                    if ($field['name'] === $primary_field) {
                        $field_exists = true;
                        
                        // Primary key fields must be NOT NULL
                        if (empty($field['not_null'])) {
                            $errors[] = "Primary key field '{$primary_field}' in table '{$table_name}' must be NOT NULL";
                        }
                        
                        break;
                    }
                }
                
                if (!$field_exists) {
                    $errors[] = "Primary key field '{$primary_field}' in table '{$table_name}' does not exist in field definitions";
                }
            }
        } else {
            $warnings[] = "Table '{$table_name}' has no primary key defined";
        }
        
        // Check indexes
        if (isset($table['index']) && is_array($table['index'])) {
            // Check for duplicate index names
            $index_names = [];
            foreach ($table['index'] as $index) {
                if (is_array($index) && isset($index['name'])) {
                    $lower_index_name = strtolower($index['name']);
                    if (isset($index_names[$lower_index_name])) {
                        $errors[] = "Duplicate index name '{$index['name']}' in table '{$table_name}'";
                    } else {
                        $index_names[$lower_index_name] = $index['name'];
                    }
                }
            }
            
            foreach ($table['index'] as $index) {
                if (is_array($index) && isset($index['name']) && isset($index['key'])) {
                    if (empty($index['key'])) {
                        $errors[] = "Index '{$index['name']}' in table '{$table_name}' has no key fields defined";
                        continue;
                    }
                    
                    foreach ($index['key'] as $key_field) {
                        $field_exists = false;
                        
                        foreach ($table['fields'] as $field) {
                            if ($field['name'] === $key_field) {
                                $field_exists = true;
                                break;
                            }
                        }
                        
                        if (!$field_exists) {
                            $errors[] = "Index field '{$key_field}' in index '{$index['name']}' of table '{$table_name}' does not exist in field definitions";
                        }
                    }
                }
            }
        }
        
        // Check engine
        if (isset($table['engine'])) {
            $valid_engines = ['InnoDB', 'MyISAM', 'MEMORY', 'ARCHIVE'];
            if (!in_array($table['engine'], $valid_engines)) {
                $warnings[] = "Table '{$table_name}' uses potentially unsupported engine '{$table['engine']}'";
            }
        }
        
        // Check charset and collation compatibility
        if (isset($table['charset']) && isset($table['collate'])) {
            // Basic check for utf8mb4 charset and collation compatibility
            if ($table['charset'] === 'utf8mb4' && strpos($table['collate'], 'utf8mb4_') !== 0) {
                $errors[] = "Table '{$table_name}' has mismatched charset (utf8mb4) and collation ({$table['collate']})";
            }
            // Basic check for utf8 charset and collation compatibility
            else if ($table['charset'] === 'utf8' && strpos($table['collate'], 'utf8_') !== 0) {
                $errors[] = "Table '{$table_name}' has mismatched charset (utf8) and collation ({$table['collate']})";
            }
        }
    }
    
    // Add warnings to errors array with a [WARNING] prefix
    foreach ($warnings as $warning) {
        $errors[] = "[WARNING] {$warning}";
    }
    
    return $errors;
}

/**
 * Validate a single table schema definition
 * 
 * @param array $table The table schema definition
 * @param string $table_name The name of the table
 * @return array Array of validation errors and warnings
 */
function rms_validate_table_schema($table, $table_name) {
    $errors = [];
    $warnings = [];
    
    // Check if table has fields defined
    if (!isset($table['fields']) || !is_array($table['fields']) || empty($table['fields'])) {
        $errors[] = "Table '{$table_name}' has no fields defined";
        return ['errors' => $errors, 'warnings' => $warnings];
    }
    
    // Check if table has at least one visible column
    $has_visible_column = false;
    foreach ($table['fields'] as $field) {
        if (isset($field['name']) && !empty($field['name'])) {
            $has_visible_column = true;
            break;
        }
    }
    
    if (!$has_visible_column) {
        $errors[] = "Table '{$table_name}' must have at least one visible column";
    }
    
    // Check for duplicate field names within the table
    $field_names = [];
    foreach ($table['fields'] as $field) {
        if (isset($field['name'])) {
            $lower_field_name = strtolower($field['name']);
            if (isset($field_names[$lower_field_name])) {
                $errors[] = "Duplicate field name '{$field['name']}' in table '{$table_name}'";
            } else {
                $field_names[$lower_field_name] = $field['name'];
            }
        }
    }
    
    // Check field definitions
    foreach ($table['fields'] as $index => $field) {
        // Check if field has a name
        if (!isset($field['name']) || empty($field['name'])) {
            $errors[] = "Field at index {$index} in table '{$table_name}' has no name";
            continue;
        }
        
        // Check if field has a type
        if (!isset($field['type']) || empty($field['type'])) {
            $errors[] = "Field '{$field['name']}' in table '{$table_name}' has no type";
            continue;
        }
        
        // Additional field validations...
    }
    
    return ['errors' => $errors, 'warnings' => $warnings];
}

/**
 * Check database integrity against the defined schema
 * 
 * @param \Reamur\System\Library\DB $db The database connection object
 * @return array Array of integrity issues, empty if no issues found
 */
function rms_check_database_integrity($db) {
    // Load the schema
    if (!function_exists('rms_db_schema')) {
        require_once(DIR_SYSTEM . 'helper/db_schema.php');
    }
    
    $tables = rms_db_schema();
    $issues = [];
    
    // Check each table in the schema
    foreach ($tables as $table_name => $table) {
        $db_table_name = DB_PREFIX . $table_name;
        
        // Check if table exists
        $query = $db->query("SHOW TABLES LIKE '{$db_table_name}'");
        
        if ($query->num_rows == 0) {
            $issues[] = "Table '{$db_table_name}' defined in schema but does not exist in database";
            continue;
        }
        
        // Check table structure
        $query = $db->query("DESCRIBE `{$db_table_name}`");
        $db_fields = [];
        
        foreach ($query->rows as $row) {
            $db_fields[$row['Field']] = $row;
        }
        
        // Check each field in the schema
        foreach ($table['fields'] as $field) {
            $field_name = $field['name'];
            
            if (!isset($db_fields[$field_name])) {
                $issues[] = "Field '{$field_name}' defined in schema for table '{$db_table_name}' but does not exist in database";
                continue;
            }
            
            // Check field type (basic check, not exact matching)
            $schema_type = strtolower($field['type']);
            $db_type = strtolower($db_fields[$field_name]['Type']);
            
            // Simple type comparison - could be enhanced for more precise matching
            if (strpos($db_type, $schema_type) === false && strpos($schema_type, $db_type) === false) {
                $issues[] = "Field '{$field_name}' in table '{$db_table_name}' has type '{$db_type}' in database but '{$schema_type}' in schema";
            }
            
            // Check NULL constraint
            $schema_null = empty($field['not_null']);
            $db_null = ($db_fields[$field_name]['Null'] === 'YES');
            
            if ($schema_null !== $db_null) {
                $issues[] = "Field '{$field_name}' in table '{$db_table_name}' has different NULL constraint in database vs schema";
            }
            
            // Check auto_increment
            $schema_auto_increment = !empty($field['auto_increment']);
            $db_auto_increment = (strpos($db_fields[$field_name]['Extra'], 'auto_increment') !== false);
            
            if ($schema_auto_increment !== $db_auto_increment) {
                $issues[] = "Field '{$field_name}' in table '{$db_table_name}' has different AUTO_INCREMENT setting in database vs schema";
            }
        }
        
        // Check for extra fields in database not in schema
        foreach ($db_fields as $field_name => $field_data) {
            $field_in_schema = false;
            
            foreach ($table['fields'] as $schema_field) {
                if ($schema_field['name'] === $field_name) {
                    $field_in_schema = true;
                    break;
                }
            }
            
            if (!$field_in_schema) {
                $issues[] = "Field '{$field_name}' exists in table '{$db_table_name}' but is not defined in schema";
            }
        }
    }
    
    // Check for extra tables in database not in schema
    $query = $db->query("SHOW TABLES LIKE '" . DB_PREFIX . "%'");
    
    foreach ($query->rows as $row) {
        $db_table = reset($row); // Get the first (and only) value from the row
        $schema_table = str_replace(DB_PREFIX, '', $db_table);
        
        if (!isset($tables[$schema_table])) {
            $issues[] = "Table '{$db_table}' exists in database but is not defined in schema";
        }
    }
    
    return $issues;
}

/**
 * Generate SQL to fix database integrity issues
 * 
 * @param \Reamur\System\Library\DB $db The database connection object
 * @param array $issues Array of integrity issues from rms_check_database_integrity
 * @return array Array with SQL statements and metadata to fix the issues
 */
function rms_generate_fix_sql($db, $issues) {
    // Load the schema
    if (!function_exists('rms_db_schema')) {
        require_once(DIR_SYSTEM . 'helper/db_schema.php');
    }
    
    // Load the migration helper for SQL function detection
    if (!function_exists('rms_is_sql_function')) {
        require_once(DIR_SYSTEM . 'helper/db_migration.php');
    }
    
    $tables = rms_db_schema();
    $sql_statements = [];
    
    foreach ($issues as $issue) {
        // Extract table and field names from issue message
        if (preg_match("/Table '([^']+)' defined in schema but does not exist in database/", $issue, $matches)) {
            $db_table_name = $matches[1];
            $schema_table = str_replace(DB_PREFIX, '', $db_table_name);
            
            if (isset($tables[$schema_table])) {
                $table = $tables[$schema_table];
                $sql = "CREATE TABLE `{$db_table_name}` (";
                
                // Add fields
                foreach ($table['fields'] as $field) {
                    $sql .= "`{$field['name']}` {$field['type']}";
                    
                    if (!empty($field['not_null'])) {
                        $sql .= " NOT NULL";
                    }
                    
                    if (isset($field['default'])) {
                        // Handle SQL functions and special values without quotes
                        if (function_exists('rms_is_sql_function') && rms_is_sql_function($field['default'])) {
                            $sql .= " DEFAULT " . $field['default'];
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
                if (isset($table['primary']) && !empty($table['primary'])) {
                    $primary_fields = [];
                    
                    foreach ($table['primary'] as $primary) {
                        $primary_fields[] = "`{$primary}`";
                    }
                    
                    $sql .= "PRIMARY KEY (" . implode(", ", $primary_fields) . ")";
                }
                
                $sql .= ") ENGINE=" . ($table['engine'] ?? DB_ENGINE_INNODB);
                $sql .= " CHARSET=" . ($table['charset'] ?? DB_CHARSET_UTF8MB4);
                $sql .= " COLLATE=" . ($table['collate'] ?? DB_COLLATE_UTF8MB4_GENERAL);
                
                $sql_statements[] = [
                    'sql' => $sql,
                    'type' => 'create_table',
                    'table' => $db_table_name,
                    'issue' => $issue
                ];
                
                // Add indexes if defined
                if (isset($table['index']) && is_array($table['index'])) {
                    foreach ($table['index'] as $index) {
                        if (is_array($index) && isset($index['name']) && isset($index['key']) && !empty($index['key'])) {
                            $key_fields = [];
                            
                            foreach ($index['key'] as $key_field) {
                                $key_fields[] = "`{$key_field}`";
                            }
                            
                            $index_sql = "CREATE INDEX `{$index['name']}` ON `{$db_table_name}` (" . implode(", ", $key_fields) . ")";
                            
                            $sql_statements[] = [
                                'sql' => $index_sql,
                                'type' => 'create_index',
                                'table' => $db_table_name,
                                'index' => $index['name'],
                                'issue' => "Index '{$index['name']}' needs to be created for table '{$db_table_name}'"
                            ];
                        }
                    }
                }
            }
        } else if (preg_match("/Field '([^']+)' defined in schema for table '([^']+)' but does not exist in database/", $issue, $matches)) {
            $field_name = $matches[1];
            $db_table_name = $matches[2];
            $schema_table = str_replace(DB_PREFIX, '', $db_table_name);
            
            if (isset($tables[$schema_table])) {
                $table = $tables[$schema_table];
                
                foreach ($table['fields'] as $field) {
                    if ($field['name'] === $field_name) {
                        $sql = "ALTER TABLE `{$db_table_name}` ADD COLUMN `{$field_name}` {$field['type']}";
                        
                        if (!empty($field['not_null'])) {
                            $sql .= " NOT NULL";
                        }
                        
                        if (isset($field['default'])) {
                            // Handle SQL functions and special values without quotes
                            if (function_exists('rms_is_sql_function') && rms_is_sql_function($field['default'])) {
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
                        
                        $sql_statements[] = [
                            'sql' => $sql,
                            'type' => 'add_column',
                            'table' => $db_table_name,
                            'column' => $field_name,
                            'issue' => $issue
                        ];
                        break;
                    }
                }
            }
        } else if (preg_match("/Field '([^']+)' in table '([^']+)' has type '([^']+)' in database but '([^']+)' in schema/", $issue, $matches)) {
            $field_name = $matches[1];
            $db_table_name = $matches[2];
            $db_type = $matches[3];
            $schema_type = $matches[4];
            $schema_table = str_replace(DB_PREFIX, '', $db_table_name);
            
            if (isset($tables[$schema_table])) {
                $table = $tables[$schema_table];
                
                foreach ($table['fields'] as $field) {
                    if ($field['name'] === $field_name) {
                        $sql = "ALTER TABLE `{$db_table_name}` MODIFY COLUMN `{$field_name}` {$field['type']}";
                        
                        if (!empty($field['not_null'])) {
                            $sql .= " NOT NULL";
                        } else {
                            $sql .= " NULL";
                        }
                        
                        if (isset($field['default'])) {
                            // Handle SQL functions and special values without quotes
                            if (function_exists('rms_is_sql_function') && rms_is_sql_function($field['default'])) {
                                $sql .= " DEFAULT " . $field['default'];
                            } else {
                                $sql .= " DEFAULT '" . $db->escape($field['default']) . "'";
                            }
                        }
                        
                        $sql_statements[] = [
                            'sql' => $sql,
                            'type' => 'modify_column',
                            'table' => $db_table_name,
                            'column' => $field_name,
                            'issue' => $issue
                        ];
                        break;
                    }
                }
            }
        } else if (preg_match("/Table '([^']+)' exists in database but is not defined in schema/", $issue, $matches)) {
            $db_table_name = $matches[1];
            
            // Only suggest dropping tables that start with the DB_PREFIX to avoid dropping system tables
            if (strpos($db_table_name, DB_PREFIX) === 0) {
                $sql = "DROP TABLE `{$db_table_name}`";
                
                $sql_statements[] = [
                    'sql' => $sql,
                    'type' => 'drop_table',
                    'table' => $db_table_name,
                    'issue' => $issue,
                    'dangerous' => true // Mark as dangerous operation
                ];
            }
        } else if (preg_match("/Field '([^']+)' exists in table '([^']+)' but is not defined in schema/", $issue, $matches)) {
            $field_name = $matches[1];
            $db_table_name = $matches[2];
            
            $sql = "ALTER TABLE `{$db_table_name}` DROP COLUMN `{$field_name}`";
            
            $sql_statements[] = [
                'sql' => $sql,
                'type' => 'drop_column',
                'table' => $db_table_name,
                'column' => $field_name,
                'issue' => $issue,
                'dangerous' => true // Mark as dangerous operation
            ];
        }
        // Additional issue types could be handled here
    }
    
    return $sql_statements;
}