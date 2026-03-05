<?php
namespace Reamur\Catalog\Model\Cms;

class MoocRating extends \Reamur\System\Engine\Model {
    public function addOrUpdate(int $course_id, int $customer_id, int $rating, string $review = ''): void {
        $rating = max(1, min(5, $rating));
        $existing = $this->db->query("SELECT rating_id FROM `" . DB_PREFIX . "mooc_course_rating` WHERE course_id = '" . (int)$course_id . "' AND customer_id = '" . (int)$customer_id . "'")->row;
        if ($existing) {
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_course_rating` SET rating = '" . $rating . "', review = '" . $this->db->escape($review) . "', created_at = NOW() WHERE rating_id = '" . (int)$existing['rating_id'] . "'");
        } else {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_course_rating` SET course_id = '" . (int)$course_id . "', customer_id = '" . (int)$customer_id . "', rating = '" . $rating . "', review = '" . $this->db->escape($review) . "', created_at = NOW()");
        }
    }

    public function getStats(int $course_id): array {
        $row = $this->db->query("SELECT COUNT(*) AS total, AVG(rating) AS avg FROM `" . DB_PREFIX . "mooc_course_rating` WHERE course_id = '" . (int)$course_id . "'")->row;
        return [
            'total' => (int)($row['total'] ?? 0),
            'avg' => $row['avg'] ? (float)$row['avg'] : 0.0
        ];
    }

    public function getRecent(int $course_id, int $limit = 10): array {
        $query = $this->db->query("SELECT r.*, cu.firstname, cu.lastname
            FROM `" . DB_PREFIX . "mooc_course_rating` r
            LEFT JOIN `" . DB_PREFIX . "customer` cu ON cu.customer_id = r.customer_id
            WHERE r.course_id = '" . (int)$course_id . "'
            ORDER BY r.created_at DESC
            LIMIT " . (int)$limit);
        return $query->rows;
    }
}
