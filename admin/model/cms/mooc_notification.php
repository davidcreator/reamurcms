<?php
namespace Reamur\Admin\Model\Cms;

class MoocNotification extends \Reamur\System\Engine\Model {
    private function ensureTable(): void {
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_notification'")->num_rows;
        if ($exists) return;
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mooc_notification` (
            `notification_id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_id` int(11) DEFAULT NULL,
            `course_id` int(11) DEFAULT NULL,
            `lesson_id` int(11) DEFAULT NULL,
            `channel` enum('system','email','push') NOT NULL DEFAULT 'system',
            `title` varchar(255) NOT NULL,
            `message` text NOT NULL,
            `url` varchar(512) DEFAULT NULL,
            `read_at` datetime DEFAULT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`notification_id`),
            KEY `customer_id` (`customer_id`),
            KEY `course_id` (`course_id`),
            KEY `lesson_id` (`lesson_id`),
            KEY `channel` (`channel`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
    }

    public function notifyAllCustomersForCourse(int $course_id, string $title, string $message, string $url = '', string $channel = 'system'): void {
        $this->ensureTable();
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_notification` (customer_id, course_id, channel, title, message, url, created_at)
            SELECT c.customer_id, " . (int)$course_id . ", '" . $this->db->escape($channel) . "', '" . $this->db->escape($title) . "', '" . $this->db->escape($message) . "', '" . $this->db->escape($url) . "', NOW()
            FROM `" . DB_PREFIX . "customer` c");
    }

    public function notifyCourseEnrollees(int $course_id, string $title, string $message, string $url = '', string $channel = 'system', int $lesson_id = null): void {
        $this->ensureTable();
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_notification` (customer_id, course_id, lesson_id, channel, title, message, url, created_at)
            SELECT e.customer_id, " . (int)$course_id . ", " . ($lesson_id ? (int)$lesson_id : "NULL") . ", '" . $this->db->escape($channel) . "', '" . $this->db->escape($title) . "', '" . $this->db->escape($message) . "', '" . $this->db->escape($url) . "', NOW()
            FROM `" . DB_PREFIX . "mooc_enrollment` e
            WHERE e.course_id = '" . (int)$course_id . "'");
    }
}

