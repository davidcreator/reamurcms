<?php
namespace Reamur\Catalog\Model\Cms;

class MoocPayment extends \Reamur\System\Engine\Model {
    private function ensureTable(): void {
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_payment'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "mooc_payment` (
                `payment_id` int(11) NOT NULL AUTO_INCREMENT,
                `course_id` int(11) NOT NULL,
                `customer_id` int(11) NOT NULL,
                `method` varchar(64) NOT NULL,
                `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
                `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
                `transaction_ref` varchar(128) DEFAULT NULL,
                `created_at` datetime NOT NULL,
                `paid_at` datetime DEFAULT NULL,
                PRIMARY KEY (`payment_id`),
                KEY `course_id` (`course_id`),
                KEY `customer_id` (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
    }

    public function create(int $course_id, int $customer_id, string $method, float $amount): int {
        $this->ensureTable();
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_payment` SET course_id='" . (int)$course_id . "', customer_id='" . (int)$customer_id . "', method='" . $this->db->escape($method) . "', amount='" . (float)$amount . "', status='pending', created_at=NOW()");
        return (int)$this->db->getLastId();
    }

    public function markPaid(int $payment_id, string $transaction_ref = ''): void {
        $this->ensureTable();
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_payment` SET status='paid', transaction_ref='" . $this->db->escape($transaction_ref) . "', paid_at=NOW() WHERE payment_id='" . (int)$payment_id . "'");
    }

    public function getPaidForCourse(int $course_id, int $customer_id): array {
        $this->ensureTable();
        $row = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_payment` WHERE course_id='" . (int)$course_id . "' AND customer_id='" . (int)$customer_id . "' AND status='paid' ORDER BY paid_at DESC LIMIT 1")->row;
        return $row ?? [];
    }

    public function getPayment(int $payment_id): array {
        $this->ensureTable();
        $row = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_payment` WHERE payment_id='" . (int)$payment_id . "'")->row;
        return $row ?? [];
    }
}
