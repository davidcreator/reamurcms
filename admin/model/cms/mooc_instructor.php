<?php
namespace Reamur\Admin\Model\Cms;

class MoocInstructor extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('mooc_installer');
        $installer = new \MoocInstaller($this->db);
        if (!$installer->moocTablesExist()) {
            $installer->installMoocTables();
        }
        $this->ensureColumns();
    }

    private function ensureColumns(): void {
        $columns = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_instructor` LIKE 'approved'")->num_rows;
        if (!$columns) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_instructor` ADD `approved` TINYINT(1) NOT NULL DEFAULT 0 AFTER `website`, ADD `approved_at` DATETIME NULL DEFAULT NULL AFTER `approved`");
        }
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_instructor` SET
            user_id = " . ($data['user_id'] ? "'" . (int)$data['user_id'] . "'" : "NULL") . ",
            name = '" . $this->db->escape((string)$data['name']) . "',
            bio = '" . $this->db->escape((string)($data['bio'] ?? '')) . "',
            photo = '" . $this->db->escape((string)($data['photo'] ?? '')) . "',
            headline = '" . $this->db->escape((string)($data['headline'] ?? '')) . "',
            linkedin = '" . $this->db->escape((string)($data['linkedin'] ?? '')) . "',
            twitter = '" . $this->db->escape((string)($data['twitter'] ?? '')) . "',
            website = '" . $this->db->escape((string)($data['website'] ?? '')) . "',
            created_at = NOW(),
            updated_at = NOW()");
        return (int)$this->db->getLastId();
    }

    public function edit(int $instructor_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_instructor` SET
            user_id = " . ($data['user_id'] ? "'" . (int)$data['user_id'] . "'" : "NULL") . ",
            name = '" . $this->db->escape((string)$data['name']) . "',
            bio = '" . $this->db->escape((string)($data['bio'] ?? '')) . "',
            photo = '" . $this->db->escape((string)($data['photo'] ?? '')) . "',
            headline = '" . $this->db->escape((string)($data['headline'] ?? '')) . "',
            linkedin = '" . $this->db->escape((string)($data['linkedin'] ?? '')) . "',
            twitter = '" . $this->db->escape((string)($data['twitter'] ?? '')) . "',
            website = '" . $this->db->escape((string)($data['website'] ?? '')) . "',
            updated_at = NOW()
            WHERE instructor_id = '" . (int)$instructor_id . "'");
    }

    public function delete(int $instructor_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id = '" . (int)$instructor_id . "'");
    }

    public function getInstructor(int $instructor_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id = '" . (int)$instructor_id . "'");
        return $query->row ?? [];
    }

    public function getInstructors(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "mooc_instructor` WHERE 1";
        if (!empty($filter['approved_only'])) {
            $sql .= " AND approved = 1";
        }
        $sql .= " ORDER BY approved DESC, name ASC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getApprovedInstructors(): array {
        return $this->getInstructors(['approved_only' => true, 'start' => 0, 'limit' => 1000]);
    }

    public function approve(int $instructor_id): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_instructor` SET approved = 1, approved_at = NOW(), updated_at = NOW() WHERE instructor_id = '" . (int)$instructor_id . "'");
    }

    public function getTotalInstructors(): int {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_instructor`");
        return (int)$query->row['total'];
    }
}
