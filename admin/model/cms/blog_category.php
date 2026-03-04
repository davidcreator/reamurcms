<?php
namespace Reamur\Admin\Model\Cms;

class BlogCategory extends \Reamur\System\Engine\Model {
    private const TABLE = DB_PREFIX . 'blog_category';

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

    public function add(array $data): int {
        $parent_id = (int)($data['parent_id'] ?? 0);
        $this->db->query("INSERT INTO `" . self::TABLE . "` SET 
            parent_id = '" . $parent_id . "',
            name = '" . $this->db->escape((string)$data['name']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            meta_title = '" . $this->db->escape((string)($data['meta_title'] ?? $data['name'] ?? '')) . "',
            meta_description = '" . $this->db->escape((string)($data['meta_description'] ?? '')) . "',
            meta_keywords = '" . $this->db->escape((string)($data['meta_keywords'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            date_added = NOW(),
            date_modified = NOW()");
        return (int)$this->db->getLastId();
    }

    public function edit(int $category_id, array $data): void {
        $parent_id = (int)($data['parent_id'] ?? 0);
        $this->db->query("UPDATE `" . self::TABLE . "` SET 
            parent_id = '" . $parent_id . "',
            name = '" . $this->db->escape((string)$data['name']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            meta_title = '" . $this->db->escape((string)($data['meta_title'] ?? $data['name'] ?? '')) . "',
            meta_description = '" . $this->db->escape((string)($data['meta_description'] ?? '')) . "',
            meta_keywords = '" . $this->db->escape((string)($data['meta_keywords'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            date_modified = NOW()
            WHERE category_id = '" . (int)$category_id . "'");
    }

    public function delete(int $category_id): void {
        $this->db->query("DELETE FROM `" . self::TABLE . "` WHERE category_id = '" . (int)$category_id . "'");
        $this->db->query("UPDATE `" . self::TABLE . "` SET parent_id = 0 WHERE parent_id = '" . (int)$category_id . "'");
    }

    public function getCategory(int $category_id): array {
        $query = $this->db->query("SELECT * FROM `" . self::TABLE . "` WHERE category_id = '" . (int)$category_id . "'");
        return $query->row ?? [];
    }

    public function getCategories(array $data = []): array {
        $sql = "SELECT * FROM `" . self::TABLE . "` WHERE 1";
        if (isset($data['status'])) {
            $sql += " AND status = '" . (int)$data['status'] . "'";
        }
        $sql .= " ORDER BY sort_order, name";

        $start = (int)($data['start'] ?? 0);
        $limit = (int)($data['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;

        return $this->db->query($sql)->rows;
    }

    public function getTotalCategories(array $data = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . self::TABLE . "` WHERE 1";
        if (isset($data['status'])) {
            $sql .= " AND status = '" . (int)$data['status'] . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    public function getCategoryOptions(): array {
        $rows = $this->db->query("SELECT category_id, name FROM `" . self::TABLE . "` ORDER BY name")->rows;
        $options = [];
        foreach ($rows as $row) {
            $options[$row['category_id']] = $row['name'];
        }
        return $options;
    }
}
