<?php
namespace Reamur\Catalog\Model\Checkout;

class Payment extends \Reamur\System\Engine\Model {
    private function ensure(): void {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "payment` (
            `payment_id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) NOT NULL,
            `context` varchar(64) NOT NULL,
            `reference_id` int(11) NOT NULL,
            `method` varchar(64) NOT NULL,
            `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
            `currency` char(3) NOT NULL DEFAULT 'BRL',
            `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
            `transaction_ref` varchar(128) DEFAULT NULL,
            `meta` json DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `paid_at` datetime DEFAULT NULL,
            PRIMARY KEY (`payment_id`),
            KEY `customer_id` (`customer_id`),
            KEY `context_ref` (`context`,`reference_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
    }

    public function create(int $customer_id, string $context, int $reference_id, string $method, float $amount, string $currency = 'BRL', array $meta = []): int {
        $this->ensure();
        $this->db->query("INSERT INTO `" . DB_PREFIX . "payment` SET customer_id='" . (int)$customer_id . "', context='" . $this->db->escape($context) . "', reference_id='" . (int)$reference_id . "', method='" . $this->db->escape($method) . "', amount='" . (float)$amount . "', currency='" . $this->db->escape($currency) . "', status='pending', meta=" . ($meta ? "'" . $this->db->escape(json_encode($meta)) . "'" : "NULL") . ", created_at=NOW()");
        return (int)$this->db->getLastId();
    }

    public function markPaid(int $payment_id, string $transaction_ref = ''): void {
        $this->ensure();
        $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET status='paid', transaction_ref='" . $this->db->escape($transaction_ref) . "', paid_at=NOW() WHERE payment_id='" . (int)$payment_id . "'");
    }

    public function getByContext(string $context, int $reference_id, int $customer_id): array {
        $this->ensure();
        $row = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payment` WHERE context='" . $this->db->escape($context) . "' AND reference_id='" . (int)$reference_id . "' AND customer_id='" . (int)$customer_id . "' AND status='paid' ORDER BY paid_at DESC LIMIT 1")->row;
        return $row ?? [];
    }

    public function getPayment(int $payment_id): array {
        $this->ensure();
        $row = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payment` WHERE payment_id='" . (int)$payment_id . "'")->row;
        return $row ?? [];
    }
}
