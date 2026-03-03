<?php
namespace Reamur\Catalog\Model\Setting;
/**
 * Class Extension
 *
 * @package Reamur\Catalog\Model\Setting
 */
class Extension extends \Reamur\System\Engine\Model {
	/**
	 * @return array
	 */
	public function getExtensions(): array {
		$query = $this->db->query("SELECT DISTINCT `extension` FROM `" . DB_PREFIX . "extension`");

		return $query->rows;
	}

	/**
	 * @param string $type
	 *
	 * @return array
	 */
	public function getExtensionsByType(string $type): array {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}

	/**
	 * @param string $type
	 * @param string $code
	 *
	 * @return array
	 */
	public function getExtensionByCode(string $type, string $code): array {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = '" . $this->db->escape($type) . "' AND `code` = '" . $this->db->escape($code) . "'");

		return $query->row;
	}
}