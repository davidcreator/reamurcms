<?php
namespace Reamur\Admin\Model\Extension\Reamur\Report;

/**
 * Class Sale
 *
 * @package Reamur\Admin\Model\Extension\Reamur\Report
 */
class Sale extends \Reamur\System\Engine\Model {
	
	/**
	 * Build status filter for SQL queries
	 *
	 * @return string
	 */
	private function buildStatusFilter(): string {
		$statuses = [];
		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$statuses[] = "'" . (int)$order_status_id . "'";
		}
		return implode(",", $statuses);
	}

	/**
	 * Build GROUP BY clause based on grouping type
	 *
	 * @param string $group
	 * @param string $tableAlias
	 * @param string $additionalFields
	 * @return string
	 */
	private function buildGroupByClause(string $group, string $tableAlias = 'o', string $additionalFields = ''): string {
		$additional = $additionalFields ? ", {$additionalFields}" : '';
		
		switch ($group) {
			case 'day':
				return " GROUP BY YEAR({$tableAlias}.`date_added`), MONTH({$tableAlias}.`date_added`), DAY({$tableAlias}.`date_added`){$additional}";
			case 'week':
				return " GROUP BY YEAR({$tableAlias}.`date_added`), WEEK({$tableAlias}.`date_added`){$additional}";
			case 'month':
				return " GROUP BY YEAR({$tableAlias}.`date_added`), MONTH({$tableAlias}.`date_added`){$additional}";
			case 'year':
				return " GROUP BY YEAR({$tableAlias}.`date_added`){$additional}";
			default:
				return " GROUP BY YEAR({$tableAlias}.`date_added`), WEEK({$tableAlias}.`date_added`){$additional}";
		}
	}

	/**
	 * Build COUNT DISTINCT clause for total queries
	 *
	 * @param string $group
	 * @param string $tableAlias
	 * @param string $additionalFields
	 * @return string
	 */
	private function buildCountDistinctClause(string $group, string $tableAlias = 'o', string $additionalFields = ''): string {
		$additional = $additionalFields ? ", {$additionalFields}" : '';
		
		switch ($group) {
			case 'day':
				return "COUNT(DISTINCT YEAR({$tableAlias}.`date_added`), MONTH({$tableAlias}.`date_added`), DAY({$tableAlias}.`date_added`){$additional})";
			case 'week':
				return "COUNT(DISTINCT YEAR({$tableAlias}.`date_added`), WEEK({$tableAlias}.`date_added`){$additional})";
			case 'month':
				return "COUNT(DISTINCT YEAR({$tableAlias}.`date_added`), MONTH({$tableAlias}.`date_added`){$additional})";
			case 'year':
				return "COUNT(DISTINCT YEAR({$tableAlias}.`date_added`){$additional})";
			default:
				return "COUNT(DISTINCT YEAR({$tableAlias}.`date_added`), WEEK({$tableAlias}.`date_added`){$additional})";
		}
	}

	/**
	 * Apply common filters to SQL query
	 *
	 * @param string $sql
	 * @param array $data
	 * @param string $tableAlias
	 * @return string
	 */
	private function applyCommonFilters(string $sql, array $data, string $tableAlias = 'o'): string {
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND {$tableAlias}.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE({$tableAlias}.`date_added`) >= DATE('" . $this->db->escape((string)$data['filter_date_start']) . "')";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE({$tableAlias}.`date_added`) <= DATE('" . $this->db->escape((string)$data['filter_date_end']) . "')";
		}

		return $sql;
	}

	/**
	 * Apply pagination to SQL query
	 *
	 * @param string $sql
	 * @param array $data
	 * @return string
	 */
	private function applyPagination(string $sql, array $data): string {
		if (isset($data['start']) || isset($data['limit'])) {
			$start = max(0, (int)($data['start'] ?? 0));
			$limit = max(1, (int)($data['limit'] ?? 20));
			$sql .= " LIMIT {$start}, {$limit}";
		}

		return $sql;
	}

	/**
	 * Get total sales amount
	 *
	 * @param array $data
	 * @return float
	 */
	public function getTotalSales(array $data = []): float {
		$sql = "SELECT SUM(`total`) AS `total` FROM `" . DB_PREFIX . "order` WHERE `order_status_id` > '0'";

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(`date_added`) = DATE('" . $this->db->escape((string)$data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return (float)($query->row['total'] ?? 0);
	}

	/**
	 * Get total orders grouped by country
	 *
	 * @return array
	 */
	public function getTotalOrdersByCountry(): array {
		$sql = "SELECT COUNT(*) AS total, SUM(o.`total`) AS amount, c.`iso_code_2`, c.`name` as country_name 
				FROM `" . DB_PREFIX . "order` o 
				LEFT JOIN `" . DB_PREFIX . "country` c ON (o.`payment_country_id` = c.`country_id`) 
				WHERE o.`order_status_id` > '0' 
				GROUP BY o.`payment_country_id`, c.`iso_code_2`, c.`name`
				ORDER BY total DESC";

		$query = $this->db->query($sql);

		return $query->rows ?? [];
	}

	/**
	 * Get total orders by hour of day (24-hour format)
	 *
	 * @return array
	 */
	public function getTotalOrdersByDay(): array {
		$statusFilter = $this->buildStatusFilter();
		
		// Initialize array with all 24 hours
		$order_data = [];
		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = [
				'hour'  => $i,
				'total' => 0
			];
		}

		if (!empty($statusFilter)) {
			$sql = "SELECT COUNT(*) AS total, HOUR(`date_added`) AS hour 
					FROM `" . DB_PREFIX . "order` 
					WHERE `order_status_id` IN({$statusFilter}) 
					AND DATE(`date_added`) = CURDATE() 
					GROUP BY HOUR(`date_added`) 
					ORDER BY HOUR(`date_added`) ASC";

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$hour = (int)$result['hour'];
				if (isset($order_data[$hour])) {
					$order_data[$hour] = [
						'hour'  => $hour,
						'total' => (int)$result['total']
					];
				}
			}
		}

		return array_values($order_data);
	}

	/**
	 * Get total orders by day of week
	 *
	 * @return array
	 */
	public function getTotalOrdersByWeek(): array {
		$statusFilter = $this->buildStatusFilter();
		
		// Initialize array for current week
		$order_data = [];
		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));
			$dayOfWeek = date('w', strtotime($date));
			
			$order_data[$dayOfWeek] = [
				'day'   => date('D', strtotime($date)),
				'date'  => $date,
				'total' => 0
			];
		}

		if (!empty($statusFilter)) {
			$sql = "SELECT COUNT(*) AS total, `date_added` 
					FROM `" . DB_PREFIX . "order` 
					WHERE `order_status_id` IN({$statusFilter}) 
					AND DATE(`date_added`) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') 
					GROUP BY DATE(`date_added`)";

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$dayOfWeek = date('w', strtotime($result['date_added']));
				if (isset($order_data[$dayOfWeek])) {
					$order_data[$dayOfWeek]['total'] = (int)$result['total'];
				}
			}
		}

		return array_values($order_data);
	}

	/**
	 * Get total orders by day of month
	 *
	 * @return array
	 */
	public function getTotalOrdersByMonth(): array {
		$statusFilter = $this->buildStatusFilter();
		
		// Initialize array for current month
		$order_data = [];
		$daysInMonth = date('t');

		for ($i = 1; $i <= $daysInMonth; $i++) {
			$date = date('Y-m-') . sprintf('%02d', $i);
			
			$order_data[$i] = [
				'day'   => sprintf('%02d', $i),
				'date'  => $date,
				'total' => 0
			];
		}

		if (!empty($statusFilter)) {
			$sql = "SELECT COUNT(*) AS total, `date_added` 
					FROM `" . DB_PREFIX . "order` 
					WHERE `order_status_id` IN({$statusFilter}) 
					AND YEAR(`date_added`) = YEAR(CURDATE())
					AND MONTH(`date_added`) = MONTH(CURDATE())
					GROUP BY DATE(`date_added`)";

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$dayOfMonth = (int)date('j', strtotime($result['date_added']));
				if (isset($order_data[$dayOfMonth])) {
					$order_data[$dayOfMonth]['total'] = (int)$result['total'];
				}
			}
		}

		return array_values($order_data);
	}

	/**
	 * Get total orders by month of year
	 *
	 * @return array
	 */
	public function getTotalOrdersByYear(): array {
		$statusFilter = $this->buildStatusFilter();
		
		// Initialize array for all 12 months
		$order_data = [];
		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = [
				'month' => date('M', mktime(0, 0, 0, $i, 1)),
				'month_num' => $i,
				'total' => 0
			];
		}

		if (!empty($statusFilter)) {
			$sql = "SELECT COUNT(*) AS total, `date_added` 
					FROM `" . DB_PREFIX . "order` 
					WHERE `order_status_id` IN({$statusFilter}) 
					AND YEAR(`date_added`) = YEAR(CURDATE()) 
					GROUP BY MONTH(`date_added`)";

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$monthNum = (int)date('n', strtotime($result['date_added']));
				if (isset($order_data[$monthNum])) {
					$order_data[$monthNum]['total'] = (int)$result['total'];
				}
			}
		}

		return array_values($order_data);
	}

	/**
	 * Get orders with detailed information
	 *
	 * @param array $data
	 * @return array
	 */
	public function getOrders(array $data = []): array {
		$sql = "SELECT 
					MIN(o.`date_added`) AS date_start, 
					MAX(o.`date_added`) AS date_end, 
					COUNT(*) AS orders, 
					SUM(COALESCE((
						SELECT SUM(op.`quantity`) 
						FROM `" . DB_PREFIX . "order_product` op 
						WHERE op.`order_id` = o.`order_id`
					), 0)) AS products,
					SUM(COALESCE((
						SELECT SUM(ot.`value`) 
						FROM `" . DB_PREFIX . "order_total` ot 
						WHERE ot.`order_id` = o.`order_id` AND ot.`code` = 'tax'
					), 0)) AS tax,
					SUM(o.`total`) AS `total` 
				FROM `" . DB_PREFIX . "order` o";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.`order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data, 'o');

		$group = $data['filter_group'] ?? 'week';
		$sql .= $this->buildGroupByClause($group, 'o');
		$sql .= " ORDER BY o.`date_added` DESC";
		$sql = $this->applyPagination($sql, $data);

		$query = $this->db->query($sql);

		return $query->rows ?? [];
	}

	/**
	 * Get total count of orders (for pagination)
	 *
	 * @param array $data
	 * @return int
	 */
	public function getTotalOrders(array $data = []): int {
		$group = $data['filter_group'] ?? 'week';
		$countClause = $this->buildCountDistinctClause($group);
		
		$sql = "SELECT {$countClause} AS `total` FROM `" . DB_PREFIX . "order`";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE `order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE `order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data);

		$query = $this->db->query($sql);

		return (int)($query->row['total'] ?? 0);
	}

	/**
	 * Get tax information grouped by period
	 *
	 * @param array $data
	 * @return array
	 */
	public function getTaxes(array $data = []): array {
		$sql = "SELECT 
					MIN(o.`date_added`) AS date_start, 
					MAX(o.`date_added`) AS date_end, 
					ot.`title`, 
					SUM(ot.`value`) AS total, 
					COUNT(DISTINCT o.`order_id`) AS `orders` 
				FROM `" . DB_PREFIX . "order` o 
				LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (ot.`order_id` = o.`order_id`) 
				WHERE ot.`code` = 'tax'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.`order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data, 'o');

		$group = $data['filter_group'] ?? 'week';
		$sql .= $this->buildGroupByClause($group, 'o', 'ot.`title`');
		$sql .= " ORDER BY o.`date_added` DESC";
		$sql = $this->applyPagination($sql, $data);

		$query = $this->db->query($sql);

		return $query->rows ?? [];
	}

	/**
	 * Get total count of tax records (for pagination)
	 *
	 * @param array $data
	 * @return int
	 */
	public function getTotalTaxes(array $data = []): int {
		$group = $data['filter_group'] ?? 'week';
		$countClause = $this->buildCountDistinctClause($group, 'o', 'ot.`title`');
		
		$sql = "SELECT {$countClause} AS `total` 
				FROM `" . DB_PREFIX . "order` o 
				LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.`order_id` = ot.`order_id`) 
				WHERE ot.`code` = 'tax'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.`order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data, 'o');

		$query = $this->db->query($sql);

		return (int)($query->row['total'] ?? 0);
	}

	/**
	 * Get shipping information grouped by period
	 *
	 * @param array $data
	 * @return array
	 */
	public function getShipping(array $data = []): array {
		$sql = "SELECT 
					MIN(o.`date_added`) AS date_start, 
					MAX(o.`date_added`) AS date_end, 
					ot.`title`, 
					SUM(ot.`value`) AS total, 
					COUNT(DISTINCT o.`order_id`) AS orders 
				FROM `" . DB_PREFIX . "order` o 
				LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.`order_id` = ot.`order_id`) 
				WHERE ot.`code` = 'shipping'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.`order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data, 'o');

		$group = $data['filter_group'] ?? 'week';
		$sql .= $this->buildGroupByClause($group, 'o', 'ot.`title`');
		$sql .= " ORDER BY o.`date_added` DESC";
		$sql = $this->applyPagination($sql, $data);

		$query = $this->db->query($sql);

		return $query->rows ?? [];
	}

	/**
	 * Get total count of shipping records (for pagination)
	 *
	 * @param array $data
	 * @return int
	 */
	public function getTotalShipping(array $data = []): int {
		$group = $data['filter_group'] ?? 'week';
		$countClause = $this->buildCountDistinctClause($group, 'o', 'ot.`title`');
		
		$sql = "SELECT {$countClause} AS `total` 
				FROM `" . DB_PREFIX . "order` o 
				LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.`order_id` = ot.`order_id`) 
				WHERE ot.`code` = 'shipping'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.`order_status_id` = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.`order_status_id` > '0'";
		}

		$sql = $this->applyCommonFilters($sql, $data, 'o');

		$query = $this->db->query($sql);

		return (int)($query->row['total'] ?? 0);
	}
}