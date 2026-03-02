<?php

// ADD THESE LINES TO THE VERY TOP OF admin/index.php
// Before any existing code

/*error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug_error.log');

// Increase memory limit for admin
ini_set('memory_limit', '256M');

// Debug output to see if file is being processed
echo "<!-- Admin Debug: Starting admin/index.php -->\n";
echo "<!-- Debug: " . date('Y-m-d H:i:s') . " -->\n";

// Catch any fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "\n<!-- FATAL ERROR DETECTED -->\n";
        echo "<!-- Error: " . $error['message'] . " -->\n";
        echo "<!-- File: " . $error['file'] . " -->\n";
        echo "<!-- Line: " . $error['line'] . " -->\n";
        
        // Also log to file
        file_put_contents(__DIR__ . '/fatal_error.log', 
            date('Y-m-d H:i:s') . " - FATAL: " . $error['message'] . 
            " in " . $error['file'] . " on line " . $error['line'] . "\n", 
            FILE_APPEND
        );
    }
});*/

// Version
define('VERSION', '1.0.0.0');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Installs
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit();
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Framework
require_once(DIR_SYSTEM . 'framework.php');
