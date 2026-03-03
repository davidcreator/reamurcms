<?php
namespace Reamur\Admin\Model\Cms;

class MoocCourse extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('mooc_installer');
        $installer = new \MoocInstaller($this->db);
        if (!$installer->moocTablesExist()) {
            $installer->installMoocTables();
        }
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_course` SET
            title = '" . $this->db->escape((string)$data['title']) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            subtitle = '" . $this->db->escape((string)($data['subtitle'] ?? '')) . "',
            description = '" . $this->db->escape((string)$data['description']) . "',
            objectives = '" . $this->db->escape((string)($data['objectives'] ?? '')) . "',
            level = '" . $this->db->escape((string)($data['level'] ?? 'all')) . "',
            language = '" . $this->db->escape((string)($data['language'] ?? 'en')) . "',
            duration_minutes = '" . (int)($data['duration_minutes'] ?? 0) . "',
            price = '" . (float)($data['price'] ?? 0) . "',
            is_free = '" . (int)($data['is_free'] ?? 0) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_added = NOW(),
            date_modified = NOW()");
        return $this->db->getLastId();
    }

    public function edit(int $course_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_course` SET
            title = '" . $this->db->escape((string)$data['title']) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            subtitle = '" . $this->db->escape((string)($data['subtitle'] ?? '')) . "',
            description = '" . $this->db->escape((string)$data['description']) . "',
            objectives = '" . $this->db->escape((string)($data['objectives'] ?? '')) . "',
            level = '" . $this->db->escape((string)($data['level'] ?? 'all')) . "',
            language = '" . $this->db->escape((string)($data['language'] ?? 'en')) . "',
            duration_minutes = '" . (int)($data['duration_minutes'] ?? 0) . "',
            price = '" . (float)($data['price'] ?? 0) . "',
            is_free = '" . (int)($data['is_free'] ?? 0) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_modified = NOW()
            WHERE course_id = '" . (int)$course_id . "'");
    }

    public function delete(int $course_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_course` WHERE course_id = '" . (int)$course_id . "'");
    }

    public function getCourse(int $course_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE course_id = '" . (int)$course_id . "'");
        return $query->row ?? [];
    }

    public function getCourses(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE 1";
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

    public function getTotalCourses(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_course` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
