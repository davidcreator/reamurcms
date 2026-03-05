<?php
namespace Reamur\Admin\Model\Setting;

class SubscriptionPlan extends \Reamur\System\Engine\Model {
    private function ensure(): void {
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "subscription_plan'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "subscription_plan` (
                `plan_id` int(11) NOT NULL AUTO_INCREMENT,
                `code` varchar(64) NOT NULL,
                `name` varchar(255) NOT NULL,
                `description` text DEFAULT NULL,
                `price` decimal(10,2) NOT NULL DEFAULT 0.00,
                `currency` char(3) NOT NULL DEFAULT 'BRL',
                `period_days` int(11) NOT NULL DEFAULT 30,
                `status` tinyint(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`plan_id`), UNIQUE KEY `code` (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
    }

    public function add(array $data): int {
        $this->ensure();
        $this->db->query("INSERT INTO `" . DB_PREFIX . "subscription_plan` SET code='" . $this->db->escape($data['code']) . "', name='" . $this->db->escape($data['name']) . "', description='" . $this->db->escape($data['description']) . "', price='" . (float)$data['price'] . "', currency='" . $this->db->escape($data['currency']) . "', period_days='" . (int)$data['period_days'] . "', status='" . (int)$data['status'] . "'");
        return (int)$this->db->getLastId();
    }

    public function edit(int $plan_id, array $data): void {
        $this->ensure();
        $this->db->query("UPDATE `" . DB_PREFIX . "subscription_plan` SET code='" . $this->db->escape($data['code']) . "', name='" . $this->db->escape($data['name']) . "', description='" . $this->db->escape($data['description']) . "', price='" . (float)$data['price'] . "', currency='" . $this->db->escape($data['currency']) . "', period_days='" . (int)$data['period_days'] . "', status='" . (int)$data['status'] . "' WHERE plan_id='" . (int)$plan_id . "'");
    }

    public function delete(int $plan_id): void {
        $this->ensure();
        $this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_plan` WHERE plan_id='" . (int)$plan_id . "'");
    }

    public function getPlans(): array {
        $this->ensure();
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_plan` ORDER BY price ASC")->rows;
    }

    public function getPlan(int $plan_id): array {
        $this->ensure();
        $row = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_plan` WHERE plan_id='" . (int)$plan_id . "'")->row;
        return $row ?? [];
    }
}
