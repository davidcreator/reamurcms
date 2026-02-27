<?php
namespace Reamur\Install\Model\Install;
/**
 * Class Install
 * @package Reamur\Install\Model\Install
 */
class Install extends \Reamur\System\Engine\Model {
	/**
	 * @param array $data
	 * @return void
	 * @throws \Exception
	 */
	public function database(array $data): void {
		$db = new \Reamur\System\Library\DB($data['db_driver'], html_entity_decode($data['db_hostname'], ENT_QUOTES, 'UTF-8'), html_entity_decode($data['db_username'], ENT_QUOTES, 'UTF-8'), html_entity_decode($data['db_password'], ENT_QUOTES, 'UTF-8'), html_entity_decode($data['db_database'], ENT_QUOTES, 'UTF-8'), $data['db_port']);

		// Structure
		$this->load->helper('db_schema');

		$tables = rms_db_schema();

		// Clear any old db foreign key constraints
		/*
		foreach ($tables as $table) {
			$foreign_query = $db->query("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = '" . html_entity_decode($data['db_database'], ENT_QUOTES, 'UTF-8') . "' AND TABLE_NAME = '" . $data['db_prefix'] . $table['name'] . "' AND CONSTRAINT_TYPE = 'FOREIGN KEY'");

			foreach ($foreign_query->rows as $foreign) {
				$db->query("ALTER TABLE `" . $data['db_prefix'] . $table['name'] . "` DROP FOREIGN KEY `" . $foreign['CONSTRAINT_NAME'] . "`");
			}
		}
		*/

		// Clear old DB
		foreach ($tables as $key => $table) {
			$db->query("DROP TABLE IF EXISTS `" . $data['db_prefix'] . $key . "`");
		}

		// Need to sort the creation of tables on foreign keys
		foreach ($tables as $key => $table) {
			// FIX: Use the key directly as table name, no need for 'rms_' prefix
			$table_name = $table['name'] ?? $key;
			
			$sql = "CREATE TABLE `" . $data['db_prefix'] . $table_name . "` (" . "\n";

			if (isset($table['fields']) && is_array($table['fields'])) {
				foreach ($table['fields'] as $field) {
					$sql .= "  `" . $field['name'] . "` " . $field['type'] . (!empty($field['not_null']) ? " NOT NULL" : "") . (isset($field['default']) ? " DEFAULT '" . $db->escape($field['default']) . "'" : "") . (!empty($field['auto_increment']) ? " AUTO_INCREMENT" : "") . ",\n";
				}
			}

			if (isset($table['primary'])) {
				$primary_data = [];

				foreach ($table['primary'] as $primary) {
					$primary_data[] = "`" . $primary . "`";
				}

				$sql .= "  PRIMARY KEY (" . implode(",", $primary_data) . "),\n";
			}

			if (isset($table['index'])) {
				if (is_array($table['index'])) {
					// Check if it's a sequential array (numeric keys) or associative array
					if (array_keys($table['index']) === range(0, count($table['index']) - 1)) {
						// Sequential array - each value is a field to index
						foreach ($table['index'] as $field_name) {
							if (is_array($field_name) && isset($field_name['name']) && isset($field_name['key'])) {
								// It's a complex index definition with name and key
								$index_data = [];
								foreach ($field_name['key'] as $key) {
									$index_data[] = "`" . $key . "`";
								}
								$sql .= "  KEY `" . $field_name['name'] . "` (" . implode(",", $index_data) . "),\n";
							} else {
								// It's a simple field name
								$sql .= "  KEY `" . $field_name . "` (`" . $field_name . "`),\n";
							}
						}
					} else {
						// Associative array - key is index name, value is index definition
						foreach ($table['index'] as $index_name => $index) {
							// Handle both formats: array of arrays with 'name' and 'key' OR just field names
							if (is_array($index) && isset($index['key'])) {
								$index_data = [];
								foreach ($index['key'] as $key) {
									$index_data[] = "`" . $key . "`";
								}
								$sql .= "  KEY `" . $index['name'] . "` (" . implode(",", $index_data) . "),\n";
							} else {
								// Simple index format where index is just the field name
								$sql .= "  KEY `" . $index_name . "` (`" . $index_name . "`),\n";
							}
						}
					}
				} else {
					// Handle case where index is just a single field name
					$sql .= "  KEY `" . $table['index'] . "` (`" . $table['index'] . "`),\n";
				}
			}

			$sql = rtrim($sql, ",\n") . "\n";
			$sql .= ") ENGINE=" . ($table['engine'] ?? 'InnoDB') . " CHARSET=" . ($table['charset'] ?? 'utf8mb4') . " ROW_FORMAT=DYNAMIC COLLATE=" . ($table['collate'] ?? 'utf8mb4_general_ci') . ";\n";

			// Add table into another array so that it can be sorted to avoid foreign keys from being incorrectly formed.
			$db->query($sql);
		}

		// Setup foreign keys
		/*
		foreach ($tables as $key => $table) {
			if (isset($table['foreign'])) {
				foreach ($table['foreign'] as $foreign) {
					$db->query("ALTER TABLE `" . $data['db_prefix'] . $key . "` ADD FOREIGN KEY (`" . $foreign['key'] . "`) REFERENCES `" . $data['db_prefix'] . $foreign['table'] . "` (`" . $foreign['field'] . "`);");
				}
			}
		}
		*/
		// Data
		$lines = file(DIR_APPLICATION . 'reamurcms.sql', FILE_IGNORE_NEW_LINES);

		if ($lines) {
			$sql = '';

			$start = false;

			foreach ($lines as $line) {
				if (substr($line, 0, 12) == 'INSERT INTO ') {
					$sql = '';

					$start = true;
				}

				if ($start) {
					$sql .= $line;
				}

				if (substr($line, -2) == ');') {
					$db->query(str_replace("INSERT INTO `rms_", "INSERT INTO `" . $data['db_prefix'], $sql));

					$start = false;
				}
			}
		}

		$db->query("SET CHARACTER SET utf8mb4");
		
		$db->query("SET @@session.sql_mode = ''");

		$db->query("DELETE FROM `" . $data['db_prefix'] . "user` WHERE `user_id` = '1'");
		$db->query("INSERT INTO `" . $data['db_prefix'] . "user` SET `user_id` = '1', `user_group_id` = '1', `username` = '" . $db->escape($data['username']) . "', `password` = '" . $db->escape(password_hash(html_entity_decode($data['password'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT)) . "', `firstname` = 'John', `lastname` = 'Doe', `email` = '" . $db->escape($data['email']) . "', `status` = '1', `date_added` = NOW()");

		$db->query("UPDATE `" . $data['db_prefix'] . "setting` SET `code` = 'config', `key` = 'config_email', `value` = '" . $db->escape($data['email']) . "' WHERE `key` = 'config_email'");

		$db->query("DELETE FROM `" . $data['db_prefix'] . "setting` WHERE `key` = 'config_encryption'");
		$db->query("INSERT INTO `" . $data['db_prefix'] . "setting` SET `code` = 'config', `key` = 'config_encryption', `value` = '" . $db->escape(rms_token(512)) . "'");

		$db->query("INSERT INTO `" . $data['db_prefix'] . "api` SET `username` = 'Default', `key` = '" . $db->escape(rms_token(256)) . "', `status` = '1', `date_added` = NOW(), `date_modified` = NOW()");

		$api_id = $db->getLastId();

		$db->query("DELETE FROM `" . $data['db_prefix'] . "setting` WHERE `key` = 'config_api_id'");
		$db->query("INSERT INTO `" . $data['db_prefix'] . "setting` SET `code` = 'config', `key` = 'config_api_id', `value` = '" . (int)$api_id . "'");

		// set the current years prefix
		$db->query("UPDATE `" . $data['db_prefix'] . "setting` SET `value` = 'INV-" . date('Y') . "-00' WHERE `key` = 'config_invoice_prefix'");
	}
}