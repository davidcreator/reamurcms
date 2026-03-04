<?php
namespace Reamur\Admin\Model\Cms;

class BlogComment extends \Reamur\System\Engine\Model {
    private const TABLE = DB_PREFIX . 'blog_comment';

    public function ensureTables(): void {
        $this->load->helper('blog_installer');
        $installer = new \BlogInstaller($this->db);
        if (method_exists($installer, 'upgradeBlogTables')) {
            $installer->blogTablesExist() ? $installer->upgradeBlogTables() : $installer->installBlogTables();
        } else {
            if (!$installer->blogTablesExist()) {
                $installer->installBlogTables();
            }
        }
    }

    public function getComments(array $filter = []): array {
        $sql = "SELECT c.*, p.title AS post_title FROM `" . self::TABLE . "` c 
                LEFT JOIN `" . DB_PREFIX . "blog_post` p ON p.post_id = c.blog_post_id
                WHERE 1";

        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND c.status = '" . (int)$filter['status'] . "'";
        }
        if (!empty($filter['q'])) {
            $q = $this->db->escape('%' . $filter['q'] . '%');
            $sql .= " AND (c.author LIKE " . $q . " OR c.email LIKE " . $q . " OR c.content LIKE " . $q . ")";
        }

        $sql .= " ORDER BY c.date_added DESC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;

        return $this->db->query($sql)->rows;
    }

    public function getTotal(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . self::TABLE . "` WHERE 1";
        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND status = '" . (int)$filter['status'] . "'";
        }
        if (!empty($filter['q'])) {
            $q = $this->db->escape('%' . $filter['q'] . '%');
            $sql .= " AND (author LIKE " . $q . " OR email LIKE " . $q . " OR content LIKE " . $q . ")";
        }
        $row = $this->db->query($sql)->row;
        return (int)($row['total'] ?? 0);
    }

    public function getComment(int $comment_id): array {
        $query = $this->db->query("SELECT * FROM `" . self::TABLE . "` WHERE comment_id = '" . (int)$comment_id . "'");
        return $query->row ?? [];
    }

    public function updateStatus(array $ids, int $status): void {
        if (empty($ids)) return;
        $escaped = implode("','", array_map('intval', $ids));
        $this->db->query("UPDATE `" . self::TABLE . "` SET status = '" . (int)$status . "', date_modified = NOW() WHERE comment_id IN ('" . $escaped . "')");
    }

    public function delete(array $ids): void {
        if (empty($ids)) return;
        $escaped = implode("','", array_map('intval', $ids));
        $this->db->query("DELETE FROM `" . self::TABLE . "` WHERE comment_id IN ('" . $escaped . "')");
    }
}
