<?php
namespace Reamur\Admin\Model\User;

/**
 * Class User Group
 *
 * @package Reamur\Admin\Model\User
 */
class UserGroup extends \Reamur\System\Engine\Model {
	/**
	 * @param array $data
	 *
	 * @return int
	 */
	public function addUserGroup(array $data): int {
		// Validar dados obrigatórios
		if (empty($data['name'])) {
			throw new \InvalidArgumentException('Nome do grupo é obrigatório');
		}

		// Preparar permissões
		$permission = '';
		if (isset($data['permission']) && is_array($data['permission'])) {
			$permission = $this->db->escape(json_encode($data['permission']));
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "user_group` SET `name` = '" . $this->db->escape((string)$data['name']) . "', `permission` = '" . $permission . "'");
	
		return $this->db->getLastId();
	}

	/**
	 * @param int   $user_group_id
	 * @param array $data
	 *
	 * @return void
	 */
	public function editUserGroup(int $user_group_id, array $data): void {
		// Validar ID
		if ($user_group_id <= 0) {
			throw new \InvalidArgumentException('ID do grupo inválido');
		}

		// Validar dados obrigatórios
		if (empty($data['name'])) {
			throw new \InvalidArgumentException('Nome do grupo é obrigatório');
		}

		// Preparar permissões
		$permission = '';
		if (isset($data['permission']) && is_array($data['permission'])) {
			$permission = $this->db->escape(json_encode($data['permission']));
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "user_group` SET `name` = '" . $this->db->escape((string)$data['name']) . "', `permission` = '" . $permission . "' WHERE `user_group_id` = '" . (int)$user_group_id . "'");
	}

	/**
	 * @param int $user_group_id
	 *
	 * @return void
	 */
	public function deleteUserGroup(int $user_group_id): void {
		// Validar ID
		if ($user_group_id <= 0) {
			throw new \InvalidArgumentException('ID do grupo inválido');
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "user_group` WHERE `user_group_id` = '" . (int)$user_group_id . "'");
	}

	/**
	 * @param int $user_group_id
	 *
	 * @return array
	 */
	public function getUserGroup(int $user_group_id): array {
		// Validar ID
		if ($user_group_id <= 0) {
			return [];
		}

		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "user_group` WHERE `user_group_id` = '" . (int)$user_group_id . "'");

		// Verificar se encontrou o registro
		if (!$query->num_rows) {
			return [];
		}

		// Decodificar permissões com segurança
		$permissions = [];
		if (!empty($query->row['permission'])) {
			$decoded = json_decode($query->row['permission'], true);
			if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
				$permissions = $decoded;
			}
		}

		$user_group = [
			'user_group_id' => (int)$query->row['user_group_id'],
			'name'          => $query->row['name'],
			'permission'    => $permissions
		];

		return $user_group;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function getUserGroups(array $data = []): array {
		$sql = "SELECT * FROM `" . DB_PREFIX . "user_group`";

		// Aplicar filtros se fornecidos
		$where = [];
		
		if (!empty($data['filter_name'])) {
			$where[] = "`name` LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if ($where) {
			$sql .= " WHERE " . implode(" AND ", $where);
		}

		// Ordenação
		$sort = isset($data['sort']) ? $data['sort'] : 'name';
		$order = isset($data['order']) && strtoupper($data['order']) === 'DESC' ? 'DESC' : 'ASC';
		
		// Validar campo de ordenação
		$allowed_sort = ['user_group_id', 'name'];
		if (!in_array($sort, $allowed_sort)) {
			$sort = 'name';
		}

		$sql .= " ORDER BY `" . $sort . "` " . $order;

		// Paginação
		if (isset($data['start']) || isset($data['limit'])) {
			$start = isset($data['start']) ? max(0, (int)$data['start']) : 0;
			$limit = isset($data['limit']) ? max(1, (int)$data['limit']) : 20;
			
			$sql .= " LIMIT " . $start . "," . $limit;
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/**
	 * @param array $data
	 *
	 * @return int
	 */
	public function getTotalUserGroups(array $data = []): int {
		$sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "user_group`";

		// Aplicar mesmos filtros do getUserGroups
		$where = [];
		
		if (!empty($data['filter_name'])) {
			$where[] = "`name` LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if ($where) {
			$sql .= " WHERE " . implode(" AND ", $where);
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}

	/**
	 * @param int    $user_group_id
	 * @param string $type
	 * @param string $route
	 *
	 * @return void
	 */
	public function addPermission(int $user_group_id, string $type, string $route): void {
		// Validar parâmetros
		if ($user_group_id <= 0) {
			throw new \InvalidArgumentException('ID do grupo inválido');
		}

		if (empty($type) || empty($route)) {
			throw new \InvalidArgumentException('Tipo e rota são obrigatórios');
		}

		// Validar tipos permitidos
		$allowed_types = ['access', 'modify'];
		if (!in_array($type, $allowed_types)) {
			throw new \InvalidArgumentException('Tipo de permissão inválido');
		}

		$user_group_query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "user_group` WHERE `user_group_id` = '" . (int)$user_group_id . "'");

		if ($user_group_query->num_rows) {
			// Decodificar permissões existentes
			$data = [];
			if (!empty($user_group_query->row['permission'])) {
				$decoded = json_decode($user_group_query->row['permission'], true);
				if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
					$data = $decoded;
				}
			}

			// Inicializar array do tipo se não existir
			if (!isset($data[$type])) {
				$data[$type] = [];
			}

			// Adicionar rota se não existir
			if (!in_array($route, $data[$type])) {
				$data[$type][] = $route;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "user_group` SET `permission` = '" . $this->db->escape(json_encode($data)) . "' WHERE `user_group_id` = '" . (int)$user_group_id . "'");
		}
	}

	/**
	 * @param int    $user_group_id
	 * @param string $type
	 * @param string $route
	 *
	 * @return void
	 */
	public function removePermission(int $user_group_id, string $type, string $route): void {
		// Validar parâmetros
		if ($user_group_id <= 0) {
			throw new \InvalidArgumentException('ID do grupo inválido');
		}

		if (empty($type) || empty($route)) {
			throw new \InvalidArgumentException('Tipo e rota são obrigatórios');
		}

		// Validar tipos permitidos
		$allowed_types = ['access', 'modify'];
		if (!in_array($type, $allowed_types)) {
			throw new \InvalidArgumentException('Tipo de permissão inválido');
		}

		$user_group_query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "user_group` WHERE `user_group_id` = '" . (int)$user_group_id . "'");

		if ($user_group_query->num_rows) {
			// Decodificar permissões existentes
			$data = [];
			if (!empty($user_group_query->row['permission'])) {
				$decoded = json_decode($user_group_query->row['permission'], true);
				if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
					$data = $decoded;
				}
			}

			// Remover rota se existir
			if (isset($data[$type]) && is_array($data[$type])) {
				$data[$type] = array_diff($data[$type], [$route]);
				// Reindexar array
				$data[$type] = array_values($data[$type]);
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "user_group` SET `permission` = '" . $this->db->escape(json_encode($data)) . "' WHERE `user_group_id` = '" . (int)$user_group_id . "'");
		}
	}

	/**
	 * Verifica se um grupo de usuário possui uma permissão específica
	 *
	 * @param int    $user_group_id
	 * @param string $type
	 * @param string $route
	 *
	 * @return bool
	 */
	public function hasPermission(int $user_group_id, string $type, string $route): bool {
		if ($user_group_id <= 0 || empty($type) || empty($route)) {
			return false;
		}

		$user_group = $this->getUserGroup($user_group_id);

		if (empty($user_group['permission'])) {
			return false;
		}

		return isset($user_group['permission'][$type]) && 
			   is_array($user_group['permission'][$type]) && 
			   in_array($route, $user_group['permission'][$type]);
	}

	/**
	 * Verifica se um nome de grupo já existe
	 *
	 * @param string $name
	 * @param int    $user_group_id (opcional, para exclusão na verificação)
	 *
	 * @return bool
	 */
	public function checkNameExists(string $name, int $user_group_id = 0): bool {
		if (empty($name)) {
			return false;
		}

		$sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "user_group` WHERE `name` = '" . $this->db->escape($name) . "'";
		
		if ($user_group_id > 0) {
			$sql .= " AND `user_group_id` != '" . (int)$user_group_id . "'";
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'] > 0;
	}
}