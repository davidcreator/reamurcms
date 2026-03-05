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
        $this->ensureTemplateTable();
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_page` SET
            title = '" . $this->db->escape((string)$data['title']) . "',
            meta_title = '" . $this->db->escape((string)($data['meta_title'] ?? ($data['title'] ?? ''))) . "',
            meta_description = '" . $this->db->escape((string)($data['meta_description'] ?? '')) . "',
            meta_keyword = '" . $this->db->escape((string)($data['meta_keyword'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            is_premium = '" . (int)($data['is_premium'] ?? 0) . "',
            price = '" . (float)($data['price'] ?? 0) . "',
            owner_id = " . (!empty($data['owner_id']) ? "'" . (int)$data['owner_id'] . "'" : "NULL") . ",
            payout_share = '" . (float)($data['payout_share'] ?? 80) . "',
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
            is_premium = '" . (int)($data['is_premium'] ?? 0) . "',
            price = '" . (float)($data['price'] ?? 0) . "',
            owner_id = " . (!empty($data['owner_id']) ? "'" . (int)$data['owner_id'] . "'" : "NULL") . ",
            payout_share = '" . (float)($data['payout_share'] ?? 80) . "',
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

    public function getTemplatesSummary(): array {
        $sql = "SELECT template, COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_page` GROUP BY template ORDER BY template";
        return $this->db->query($sql)->rows ?? [];
    }

    public function getBlocks(array $filter = []): array {
        $sql = "SELECT b.*, p.title AS page_title FROM `" . DB_PREFIX . "landpage_page_block` b 
                LEFT JOIN `" . DB_PREFIX . "landpage_page` p ON p.page_id = b.page_id
                ORDER BY p.title, b.sort_order, b.block_id";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 50);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 50;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getBlock(int $block_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "landpage_page_block` WHERE block_id = '" . (int)$block_id . "'");
        return $query->row ?? [];
    }

    public function addBlock(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_page_block` SET
            page_id = '" . (int)$data['page_id'] . "',
            type = '" . $this->db->escape((string)$data['type']) . "',
            settings = '" . $this->db->escape((string)($data['settings'] ?? '')) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "'");
        return (int)$this->db->getLastId();
    }

    public function editBlock(int $block_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "landpage_page_block` SET
            page_id = '" . (int)$data['page_id'] . "',
            type = '" . $this->db->escape((string)$data['type']) . "',
            settings = '" . $this->db->escape((string)($data['settings'] ?? '')) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "'
            WHERE block_id = '" . (int)$block_id . "'");
    }

    public function deleteBlock(int $block_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "landpage_page_block` WHERE block_id = '" . (int)$block_id . "'");
    }

    public function getTotalBlocks(): int {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_page_block`");
        return (int)($query->row['total'] ?? 0);
    }

    public function getVariants(array $filter = []): array {
        $sql = "SELECT v.*, p.title AS page_title FROM `" . DB_PREFIX . "landpage_page_variant` v 
                LEFT JOIN `" . DB_PREFIX . "landpage_page` p ON p.page_id = v.page_id
                ORDER BY p.title, v.variant_id";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 50);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 50;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getVariant(int $variant_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "landpage_page_variant` WHERE variant_id = '" . (int)$variant_id . "'");
        return $query->row ?? [];
    }

    public function addVariant(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_page_variant` SET
            page_id = '" . (int)$data['page_id'] . "',
            name = '" . $this->db->escape((string)$data['name']) . "',
            weight = '" . (int)($data['weight'] ?? 100) . "',
            status = '" . (int)($data['status'] ?? 1) . "'");
        return (int)$this->db->getLastId();
    }

    public function editVariant(int $variant_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "landpage_page_variant` SET
            page_id = '" . (int)$data['page_id'] . "',
            name = '" . $this->db->escape((string)$data['name']) . "',
            weight = '" . (int)($data['weight'] ?? 100) . "',
            status = '" . (int)($data['status'] ?? 1) . "'
            WHERE variant_id = '" . (int)$variant_id . "'");
    }

    public function deleteVariant(int $variant_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "landpage_page_variant` WHERE variant_id = '" . (int)$variant_id . "'");
    }

    public function getTotalVariants(): int {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_page_variant`");
        return (int)($query->row['total'] ?? 0);
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
            'custom_css' => "ALTER TABLE `" . $table . "` ADD COLUMN `custom_css` TEXT NULL AFTER `featured_image`",
            'is_premium' => "ALTER TABLE `" . $table . "` ADD COLUMN `is_premium` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`",
            'owner_id' => "ALTER TABLE `" . $table . "` ADD COLUMN `owner_id` INT(11) DEFAULT NULL AFTER `is_premium`",
            'payout_share' => "ALTER TABLE `" . $table . "` ADD COLUMN `payout_share` DECIMAL(5,2) NOT NULL DEFAULT 80.00 AFTER `owner_id`",
            'price' => "ALTER TABLE `" . $table . "` ADD COLUMN `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `payout_share`"
        ];

        foreach ($columns as $column => $sql) {
            $exists = $this->db->query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $this->db->escape($column) . "'");
            if (empty($exists->num_rows)) {
                $this->db->query($sql);
            }
        }
    }

    private function ensureTemplateTable(): void {
        $table = DB_PREFIX . "landpage_template";
        $exists = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($table) . "'");
        if (!$exists->num_rows) {
            $this->db->query("CREATE TABLE `" . $table . "` (
                `template_id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `code` VARCHAR(64) NOT NULL,
                `description` TEXT NULL,
                `html` LONGTEXT NOT NULL,
                `css` TEXT NULL,
                `status` TINYINT(1) NOT NULL DEFAULT 1,
                `date_added` DATETIME NOT NULL,
                `date_modified` DATETIME NOT NULL,
                PRIMARY KEY (`template_id`),
                UNIQUE KEY `code` (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        }
    }

    public function getTemplates(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "landpage_template` WHERE 1";
        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND status = '" . (int)$filter['status'] . "'";
        }
        $sql .= " ORDER BY date_modified DESC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getTemplate(int $template_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "landpage_template` WHERE template_id = '" . (int)$template_id . "'");
        return $query->row ?? [];
    }

    public function addTemplate(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "landpage_template` SET
            name = '" . $this->db->escape((string)$data['name']) . "',
            code = '" . $this->db->escape((string)$data['code']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            html = '" . $this->db->escape((string)($data['html'] ?? '')) . "',
            css = '" . $this->db->escape((string)($data['css'] ?? '')) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            date_added = NOW(),
            date_modified = NOW()");
        return (int)$this->db->getLastId();
    }

    public function editTemplate(int $template_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "landpage_template` SET
            name = '" . $this->db->escape((string)$data['name']) . "',
            code = '" . $this->db->escape((string)$data['code']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            html = '" . $this->db->escape((string)($data['html'] ?? '')) . "',
            css = '" . $this->db->escape((string)($data['css'] ?? '')) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            date_modified = NOW()
            WHERE template_id = '" . (int)$template_id . "'");
    }

    public function deleteTemplate(int $template_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "landpage_template` WHERE template_id = '" . (int)$template_id . "'");
    }

    public function getTotalTemplates(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_template` WHERE 1";
        if (isset($filter['status']) && $filter['status'] !== '') {
            $sql .= " AND status = '" . (int)$filter['status'] . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
