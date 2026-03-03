<?php
namespace Reamur\Admin\Model\Cms;

class BlogComment extends \Reamur\System\Engine\Model {
    public function getComments(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "blog_comment` WHERE 1";
        if (isset($filter['filter_status'])) {
            $sql .= " AND status = '" . (int)$filter['filter_status'] . "'";
        }
        $sql .= " ORDER BY date_added DESC";

        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;

        return $this->db->query($sql)->rows;
    }

    public function getTotalComments(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment` WHERE 1";
        if (isset($filter['filter_status'])) {
            $sql .= " AND status = '" . (int)$filter['filter_status'] . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
