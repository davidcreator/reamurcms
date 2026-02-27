<?php
/**
 * MOOC Extension Installer
 *
 * Usage (CLI):
 *   php install/extensions/mooc-extension.php
 *
 * Requirements:
 * - Application already installed (config.php present)
 * - Database credentials defined in config.php
 * - SQL bundle install/reamurcms-mooc-extension.sql available
 */

// Resolve base dir (repo root)
$dirReamur = str_replace('\\', '/', realpath(__DIR__ . '/..')) . '/';
$configFile = $dirReamur . 'config.php';

if (!is_file($configFile)) {
    exit("ERROR: config.php not found. Run the main installer first.\n");
}

require_once $configFile;

// Paths
define('DIR_REAMUR', $dirReamur);
define('DIR_SYSTEM', DIR_REAMUR . 'system/');
define('DIR_APPLICATION', DIR_REAMUR . 'install/');

// Load DB library and driver
require_once DIR_SYSTEM . 'library/db.php';
require_once DIR_SYSTEM . 'library/db/' . DB_DRIVER . '.php';

use Reamur\System\Library\DB;

try {
    $db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
} catch (Throwable $e) {
    exit("ERROR: Cannot connect to database. " . $e->getMessage() . "\n");
}

$sqlFile = DIR_APPLICATION . 'reamurcms-mooc-extension.sql';

if (!is_file($sqlFile)) {
    exit("ERROR: SQL file not found at {$sqlFile}\n");
}

$sql = file_get_contents($sqlFile);
$statements = array_filter(array_map('trim', explode(';', $sql)));

$executed = 0;
foreach ($statements as $statement) {
    if ($statement === '') {
        continue;
    }
    $db->query($statement);
    $executed++;
}

echo "SUCCESS: MOOC extension installed. {$executed} statements executed.\n";
