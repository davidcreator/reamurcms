<?php
namespace Reamur\Catalog\Model\Cms;

class MoocForum extends \Reamur\System\Engine\Model {
    public function getTopics(int $course_id, int $start = 0, int $limit = 20): array {
        $query = $this->db->query("SELECT t.*, cu.firstname, cu.lastname
            FROM `" . DB_PREFIX . "mooc_forum_topic` t
            LEFT JOIN `" . DB_PREFIX . "customer` cu ON cu.customer_id = t.customer_id
            WHERE t.course_id = '" . (int)$course_id . "'
            ORDER BY t.created_at DESC
            LIMIT " . (int)$start . "," . (int)$limit);
        return $query->rows;
    }

    public function getTopic(int $topic_id): array {
        $query = $this->db->query("SELECT t.*, cu.firstname, cu.lastname
            FROM `" . DB_PREFIX . "mooc_forum_topic` t
            LEFT JOIN `" . DB_PREFIX . "customer` cu ON cu.customer_id = t.customer_id
            WHERE t.topic_id = '" . (int)$topic_id . "'");
        return $query->row ?? [];
    }

    public function addTopic(int $course_id, int $customer_id, string $title, string $body): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_forum_topic` SET
            course_id = '" . (int)$course_id . "',
            customer_id = '" . (int)$customer_id . "',
            title = '" . $this->db->escape($title) . "',
            body = '" . $this->db->escape($body) . "',
            created_at = NOW()");
        return (int)$this->db->getLastId();
    }

    public function addReply(int $topic_id, int $customer_id, string $body): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_forum_reply` SET
            topic_id = '" . (int)$topic_id . "',
            customer_id = '" . (int)$customer_id . "',
            body = '" . $this->db->escape($body) . "',
            created_at = NOW()");
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_topic` SET replies_count = replies_count + 1 WHERE topic_id = '" . (int)$topic_id . "'");
        return (int)$this->db->getLastId();
    }

    public function getReplies(int $topic_id): array {
        $query = $this->db->query("SELECT r.*, cu.firstname, cu.lastname
            FROM `" . DB_PREFIX . "mooc_forum_reply` r
            LEFT JOIN `" . DB_PREFIX . "customer` cu ON cu.customer_id = r.customer_id
            WHERE r.topic_id = '" . (int)$topic_id . "'
            ORDER BY r.created_at ASC");
        return $query->rows;
    }

    public function toggleLike(int $reply_id, int $customer_id): void {
        $exists = $this->db->query("SELECT like_id FROM `" . DB_PREFIX . "mooc_forum_like` WHERE reply_id = '" . (int)$reply_id . "' AND customer_id = '" . (int)$customer_id . "'")->row;
        if ($exists) {
            $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_forum_like` WHERE like_id = '" . (int)$exists['like_id'] . "'");
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_reply` SET likes_count = GREATEST(likes_count-1,0) WHERE reply_id = '" . (int)$reply_id . "'");
        } else {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_forum_like` SET reply_id = '" . (int)$reply_id . "', customer_id = '" . (int)$customer_id . "'");
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_reply` SET likes_count = likes_count + 1 WHERE reply_id = '" . (int)$reply_id . "'");
        }
    }

    public function markSolution(int $topic_id, int $reply_id): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_reply` SET is_solution = 0 WHERE topic_id = '" . (int)$topic_id . "'");
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_reply` SET is_solution = 1 WHERE reply_id = '" . (int)$reply_id . "'");
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_forum_topic` SET is_solved = 1, solution_reply_id = '" . (int)$reply_id . "' WHERE topic_id = '" . (int)$topic_id . "'");
    }
}
