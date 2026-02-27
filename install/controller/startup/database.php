<?php
namespace Reamur\Install\Controller\Startup;
/**
 * Class Database
 * @package Reamur\Install\Controller\Startup
 */
class Database extends \Reamur\System\Engine\Controller {
	/**
	 * Initialize database connection from config file
	 * 
	 * @return void
	 * @throws \Exception
	 */
	public function index(): void {
		if (is_file(DIR_REAMUR . 'config.php') && filesize(DIR_REAMUR . 'config.php') > 0) {
			try {
				// Read configuration file
				$lines = @file(DIR_REAMUR . 'config.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				
				if ($lines === false) {
					throw new \Exception('Unable to read config file');
				}
				
				// Extract database configuration
				foreach ($lines as $line) {
					if (strpos(strtoupper($line), 'DB_') !== false && 
						preg_match('/define\([\'\"](.*)[\'\"],\s+[\'\"](.*)[\'\"]\)/', $line, $match, PREG_OFFSET_CAPTURE)) {
						if (!defined($match[1][0])) {
							define($match[1][0], $match[2][0]);
						}
					}
				}
				
				// Validate required database constants
				$required = ['DB_DRIVER', 'DB_HOSTNAME', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASE'];
				foreach ($required as $constant) {
					if (!defined($constant)) {
						throw new \Exception("Required database constant {$constant} not found in config file");
					}
				}
				
				// Set port with fallback
				$port = defined('DB_PORT') ? DB_PORT : ini_get('mysqli.default_port');
				
				// Initialize database connection
				$this->registry->set('db', new \Reamur\System\Library\DB(
					DB_DRIVER, 
					DB_HOSTNAME, 
					DB_USERNAME, 
					DB_PASSWORD, 
					DB_DATABASE, 
					$port
				));
			} catch (\Exception $e) {
				// Log error but don't expose sensitive details
				if ($this->config->get('error_log')) {
					$this->log->write('Database initialization error: ' . $e->getMessage());
				}
				
				// Only throw exception in development environment
				if ($this->config->get('error_display')) {
					throw $e;
				}
			}
		}
	}
}