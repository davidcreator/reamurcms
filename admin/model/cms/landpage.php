<?php
namespace Reamur\Admin\Model\Cms;

class Landpage extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('landpage_installer');
        $installer = new \LandpageInstaller($this->db);
        if (!$installer->landpageTablesExist()) {
            $installer->installLandpageTables();
        }
        $this->addMissingColumns();
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_page` SET
            title = '" . $this->db->escape((string)$data['title']) . "',
            meta_title = '" . $this->db->escape((string)($data['meta_title'] ?? ($data['title'] ?? ''))) . "',
            meta_description = '" . $this->db->escape((string)($data['meta_description'] ?? '')) . "',
            meta_keyword = '" . $this->db->escape((string)($data['meta_keyword'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            template = '" . $this->db->escape((string)($data['template'] ?? 'default')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            custom_css = '" . $this->db->escape((string)($data['custom_css'] ?? '')) . "',
            author_id = '" . (int)($data['author_id'] ?? 0) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_added = NOW(),
            date_modified = NOW()");

        $page_id = $this->db->getLastId();
        $this->saveRevision($page_id, $data['html'] ?? '', $data['author_id'] ?? 0);
        return $page_id;
    }

    public function edit(int $page_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "landpage_page` SET
            title = '" . $this->db->escape((string)$data['title']) . "',
            meta_title = '" . $this->db->escape((string)($data['meta_title'] ?? ($data['title'] ?? ''))) . "',
            meta_description = '" . $this->db->escape((string)($data['meta_description'] ?? '')) . "',
            meta_keyword = '" . $this->db->escape((string)($data['meta_keyword'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            template = '" . $this->db->escape((string)($data['template'] ?? 'default')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            custom_css = '" . $this->db->escape((string)($data['custom_css'] ?? '')) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_modified = NOW()
            WHERE page_id = '" . (int)$page_id . "'");

        if (isset($data['html'])) {
            $this->saveRevision($page_id, $data['html'], $data['author_id'] ?? 0);
        }
    }

    public function delete(int $page_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "landpage_page` WHERE page_id = '" . (int)$page_id . "'");
    }

    public function getPage(int $page_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "landpage_page` WHERE page_id = '" . (int)$page_id . "'");
        $page = $query->row ?? [];
        if ($page) {
            $page['html'] = $this->getLatestRevisionHtml($page_id);
        }
        return $page;
    }

    public function getPages(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "landpage_page` WHERE 1";
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

    public function getTotalPages(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_page` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    private function saveRevision(int $page_id, string $html, int $author_id): void {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_page_revision` SET 
            page_id = '" . (int)$page_id . "',
            html = '" . $this->db->escape($html) . "',
            author_id = '" . (int)$author_id . "',
            created_at = NOW()");
    }

    private function getLatestRevisionHtml(int $page_id): string {
        $query = $this->db->query("SELECT html FROM `" . DB_PREFIX . "landpage_page_revision` WHERE page_id = '" . (int)$page_id . "' ORDER BY revision_id DESC LIMIT 1");
        return $query->row['html'] ?? '';
    }

    private function addMissingColumns(): void {
        $table = DB_PREFIX . "landpage_page";
        $columns = [
            'meta_title' => "ALTER TABLE `" . $table . "` ADD COLUMN `meta_title` VARCHAR(255) NOT NULL DEFAULT '' AFTER `title`",
            'meta_description' => "ALTER TABLE `" . $table . "` ADD COLUMN `meta_description` TEXT NULL AFTER `meta_title`",
            'meta_keyword' => "ALTER TABLE `" . $table . "` ADD COLUMN `meta_keyword` VARCHAR(255) NOT NULL DEFAULT '' AFTER `meta_description`",
            'featured_image' => "ALTER TABLE `" . $table . "` ADD COLUMN `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `template`",
            'custom_css' => "ALTER TABLE `" . $table . "` ADD COLUMN `custom_css` TEXT NULL AFTER `featured_image`"
        ];

        foreach ($columns as $column => $sql) {
            $exists = $this->db->query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $this->db->escape($column) . "'");
            if (empty($exists->num_rows)) {
                $this->db->query($sql);
            }
        }
    }
}
