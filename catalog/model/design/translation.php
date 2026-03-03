<?php
namespace Reamur\Catalog\Model\Design;
/**
 * Class Translation
 *
 * @package Reamur\Catalog\Model\Design
 */
class Translation extends \Reamur\System\Engine\Model {
	/**
	 * @param string $route
	 *
	 * @return array
	 */
	public function getTranslations(string $route): array {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "translation` WHERE `store_id` = '" . (int)$this->config->get('config_store_id') . "' AND `language_id` = '" . (int)$this->config->get('config_language_id') . "' AND `route` = '" . $this->db->escape($route) . "'");

		return $query->rows;
	}
}
