<?php
// Version
define("VERSION", "1.0.0.0");

// Configuration
if (is_file('config.php')) {
    require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
    header('Location: install/index.php');
}

// Startup
require_once(DIR_SYSTEM . 'start.php');

// Framework
require_once(DIR_SYSTEM . 'framework.php');

// Errors
ini_set('display_erros', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);