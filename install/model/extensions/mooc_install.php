<?php
namespace Reamur\Install\Model\Extensions;

/**
 * MOOC Extension Installer (model)
 */
class MoocInstall extends \Reamur\System\Engine\Model {

	/**
	 * Run MOOC extension SQL bundle
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

		$sqlFile = DIR_APPLICATION . 'reamurcms-mooc-extension.sql';

		if (!is_file($sqlFile)) {
			throw new \Exception('MOOC extension SQL file not found: ' . $sqlFile);
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

		$this->grantAdministratorPermissions($db, $data['db_prefix'], ['cms/mooc_course']);

		return $executed;
	}

	/**
	 * Ensure Administrator group has access/modify permissions for the routes
	 *
	 * @param \Reamur\System\Library\DB $db
	 * @param string                    $prefix
	 * @param array                     $routes
	 * @return void
	 */
	private function grantAdministratorPermissions(\Reamur\System\Library\DB $db, string $prefix, array $routes): void {
		$table = '`' . preg_replace('/[^a-zA-Z0-9_]/', '', $prefix) . 'user_group`';

		$query = $db->query("SELECT user_group_id, permission FROM {$table} WHERE name='Administrator' LIMIT 1");

		if (!$query->num_rows) {
			return;
		}

		$permissions = json_decode($query->row['permission'], true) ?: [];
		$permissions['access'] = $permissions['access'] ?? [];
		$permissions['modify'] = $permissions['modify'] ?? [];

		foreach ($routes as $route) {
			if (!in_array($route, $permissions['access'])) {
				$permissions['access'][] = $route;
			}
			if (!in_array($route, $permissions['modify'])) {
				$permissions['modify'][] = $route;
			}
		}

		$json = $db->escape(json_encode($permissions, JSON_UNESCAPED_SLASHES));

		$db->query("UPDATE {$table} SET permission = '{$json}' WHERE user_group_id = '" . (int)$query->row['user_group_id'] . "'");
	}
}
