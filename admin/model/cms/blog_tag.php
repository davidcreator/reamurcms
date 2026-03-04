<?php
namespace Reamur\Admin\Model\Cms;

class BlogTag extends \Reamur\System\Engine\Model {
    private const TABLE = DB_PREFIX . 'blog_tag';

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
        $this->createTagTableIfMissing();
    }

    public function add(array $data): int {
        $this->ensureTables();
        $this->db->query("INSERT INTO `" . self::TABLE . "` SET
            name = '" . $this->db->escape((string)$data['name']) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            date_added = NOW(),
            date_modified = NOW()");
        return (int)$this->db->getLastId();
    }

    public function edit(int $tag_id, array $data): void {
        $this->ensureTables();
        $this->db->query("UPDATE `" . self::TABLE . "` SET
            name = '" . $this->db->escape((string)$data['name']) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            date_modified = NOW()
            WHERE tag_id = '" . (int)$tag_id . "'");
    }

    public function delete(array $ids): void {
        $this->ensureTables();
        if (empty($ids)) return;
        $escaped = implode("','", array_map('intval', $ids));
        $this->db->query("DELETE FROM `" . self::TABLE . "` WHERE tag_id IN ('" . $escaped . "')");
    }

    public function getTag(int $tag_id): array {
        $this->ensureTables();
        $query = $this->db->query("SELECT * FROM `" . self::TABLE . "` WHERE tag_id = '" . (int)$tag_id . "'");
        return $query->row ?? [];
    }

    public function getTags(array $filter = []): array {
        $this->ensureTables();
        $this->createTagTableIfMissing();
        $sql = "SELECT * FROM `" . self::TABLE . "` WHERE 1";
        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND status = '" . (int)$filter['status'] . "'";
        }
        if (!empty($filter['q'])) {
            $q = $this->db->escape('%' . $filter['q'] . '%');
            $sql .= " AND (name LIKE " . $q . " OR slug LIKE " . $q . ")";
        }
        $sql .= " ORDER BY sort_order, name";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 50);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 50;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getTotal(array $filter = []): int {
        $this->ensureTables();
        $this->createTagTableIfMissing();
        $sql = "SELECT COUNT(*) AS total FROM `" . self::TABLE . "` WHERE 1";
        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND status = '" . (int)$filter['status'] . "'";
        }
        if (!empty($filter['q'])) {
            $q = $this->db->escape('%' . $filter['q'] . '%');
            $sql .= " AND (name LIKE " . $q . " OR slug LIKE " . $q . ")";
        }
        $row = $this->db->query($sql)->row;
        return (int)($row['total'] ?? 0);
    }

    private function createTagTableIfMissing(): void {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . self::TABLE . "` (
            `tag_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `slug` varchar(160) NOT NULL,
            `status` tinyint(1) NOT NULL DEFAULT 1,
            `sort_order` int(3) NOT NULL DEFAULT 0,
            `date_added` datetime NOT NULL DEFAULT NOW(),
            `date_modified` datetime NOT NULL DEFAULT NOW(),
            PRIMARY KEY (`tag_id`),
            UNIQUE KEY `slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
    }
}
