<?php
namespace Reamur\Admin\Model\Cms;

class BlogPost extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('blog_installer');
        $installer = new \BlogInstaller($this->db);
        if (!$installer->blogTablesExist()) {
            $installer->installBlogTables();
        }
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "blog_post` SET 
            author_id = '" . (int)($data['author_id'] ?? 0) . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            content = '" . $this->db->escape((string)$data['content']) . "',
            excerpt = '" . $this->db->escape((string)($data['excerpt'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_added = NOW(),
            date_modified = NOW()");

        return $this->db->getLastId();
    }

    public function edit(int $post_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "blog_post` SET 
            title = '" . $this->db->escape((string)$data['title']) . "',
            content = '" . $this->db->escape((string)$data['content']) . "',
            excerpt = '" . $this->db->escape((string)($data['excerpt'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_modified = NOW()
            WHERE post_id = '" . (int)$post_id . "'");
    }

    public function delete(int $post_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "'");
    }

    public function getPost(int $post_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "'");
        return $query->row ?? [];
    }

    public function getPosts(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $sql .= " ORDER BY date_added DESC";

        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;

        return $this->db->query($sql)->rows;
    }

    public function getTotalPosts(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_post` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
