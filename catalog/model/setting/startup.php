<?php
namespace Reamur\Catalog\Model\Setting;
/**
 * Class Startup
 *
 * @package Reamur\Catalog\Model\Setting
 */
class Startup extends \Reamur\System\Engine\Model {
	/**
	 * @return mixed
	 */
	function getStartups() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "startup` WHERE `status` = '1' ORDER BY `sort_order` ASC");

		return $query->rows;
	}
}