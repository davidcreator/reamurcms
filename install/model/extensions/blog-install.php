<?php
namespace Reamur\Install\Model\Extensions;

/**
 * Blog Extension Installer (model)
 */
class BlogInstall extends \Reamur\System\Engine\Model {

	/**
	 * Run blog extension SQL bundle
	 *
	 * @param array $data Expect db_driver, db_hostname, db_username, db_password, db_database, db_port, db_prefix
	 * @return int Number of executed statements
	 * @throws \Exception
	 */
	public function install(array $data): int {
		$db = new \Reamur\System\Library\DB(
			$data['db_driver'],
			html_entity_decode($data['db_hostname'], ENT_QUOTES, 'UTF-8'),
			html_entity_decode($data['db_username'], ENT_QUOTES, 'UTF-8'),
			html_entity_decode($data['db_password'], ENT_QUOTES, 'UTF-8'),
			html_entity_decode($data['db_database'], ENT_QUOTES, 'UTF-8'),
			$data['db_port']
		);

		$sqlFile = DIR_APPLICATION . 'reamurcms-blog-extension.sql';

		if (!is_file($sqlFile)) {
			throw new \Exception('Blog extension SQL file not found: ' . $sqlFile);
		}

		$sql = file_get_contents($sqlFile);
		// Apply DB prefix
		$sql = str_replace('`rms_', '`' . $data['db_prefix'], $sql);

		$statements = array_filter(array_map('trim', explode(';', $sql)));

		$executed = 0;
		foreach ($statements as $statement) {
			if ($statement === '') {
				continue;
			}
			$db->query($statement);
			$executed++;
		}

		return $executed;
	}
}
