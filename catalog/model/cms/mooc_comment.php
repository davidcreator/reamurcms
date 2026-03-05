<?php
namespace Reamur\Catalog\Model\Cms;

class MoocComment extends \Reamur\System\Engine\Model {
    public function addComment(int $lesson_id, int $customer_id, string $body): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_comment` SET
            lesson_id = '" . (int)$lesson_id . "',
            customer_id = '" . (int)$customer_id . "',
            body = '" . $this->db->escape($body) . "',
            created_at = NOW()");
        return (int)$this->db->getLastId();
    }

    public function getComments(int $lesson_id): array {
        $query = $this->db->query("SELECT c.*, cu.firstname, cu.lastname
            FROM `" . DB_PREFIX . "mooc_comment` c
            LEFT JOIN `" . DB_PREFIX . "customer` cu ON cu.customer_id = c.customer_id
            WHERE c.lesson_id = '" . (int)$lesson_id . "'
            ORDER BY c.created_at DESC");
        return $query->rows;
    }
}
