<?php
/**
 * Database SQL Functions Helper
 * @package ReamurCMS
 * @version 1.0.0
 * 
 * This file provides functionality for normalizing and handling SQL functions
 * consistently across the database operations.
 */

/**
 * Normalize SQL function syntax for consistent usage in database operations
 * 
 * @param string $value The SQL function or value to normalize
 * @return string The normalized SQL function or original value
 */
function rms_normalize_sql_function($value) {
    if (!is_string($value)) {
        return $value;
    }
    
    // Handle specific SQL functions that need normalization
    $normalized_value = $value;
    
    // Convert CURRENT_TIMESTAMP() to CURRENT_TIMESTAMP for DEFAULT values
    // MySQL requires CURRENT_TIMESTAMP without parentheses
    if (strtoupper($value) === 'CURRENT_TIMESTAMP()') {
        $normalized_value = 'CURRENT_TIMESTAMP';
    }
    
    // Add more normalizations as needed for other SQL functions
    // For example, NOW() -> CURRENT_TIMESTAMP for consistency
    if (strtoupper($value) === 'NOW()') {
        $normalized_value = 'CURRENT_TIMESTAMP';
    }
    
    return $normalized_value;
}

/**
 * Get a list of all supported SQL functions
 * 
 * @return array Array of SQL function patterns
 */
function rms_get_sql_functions() {
    return [
        // Date and time functions - support both with and without parentheses
        '/^(CURRENT_TIMESTAMP|NOW|CURDATE|CURRENT_DATE|CURTIME|CURRENT_TIME)(\(\))?$/i',
        // String functions
        '/^(CONCAT|CONCAT_WS|UPPER|LOWER|TRIM)\(.+\)$/i',
        // Numeric functions
        '/^(ABS|ROUND|FLOOR|CEILING|RAND)\(.+\)$/i',
        // Null value
        '/^NULL$/i'
    ];
}

/**
 * Check if a value is an SQL function that should not be quoted
 * 
 * @param string $value The value to check
 * @return bool True if the value is an SQL function, false otherwise
 */
function rms_is_sql_function($value) {
    // First normalize the value
    $normalized_value = rms_normalize_sql_function($value);
    
    // Check against the list of SQL functions
    foreach (rms_get_sql_functions() as $pattern) {
        if (preg_match($pattern, $normalized_value)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Apply SQL function normalization in a DEFAULT clause context
 * 
 * @param mixed $value The value to normalize
 * @param \Reamur\System\Library\DB $db The database connection object for escaping
 * @return string The SQL DEFAULT clause fragment
 */
function rms_format_default_value($value, $db) {
    // Handle NULL value specially
    if ($value === null) {
        return " DEFAULT NULL";
    }
    
    // Check if it's an SQL function
    if (rms_is_sql_function($value)) {
        // Normalize the SQL function
        $normalized_value = rms_normalize_sql_function($value);
        return " DEFAULT " . $normalized_value;
    } else {
        // Regular value needs quotes and escaping
        return " DEFAULT '" . $db->escape($value) . "'";
    }
}