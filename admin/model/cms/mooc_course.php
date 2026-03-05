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
        $course_id = (int)$this->db->getLastId();
        $this->setCourseCategories($course_id, $data['category_ids'] ?? []);
        $this->setCourseInstructors($course_id, $data['instructor_ids'] ?? []);
        return $course_id;
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
        $this->setCourseCategories($course_id, $data['category_ids'] ?? []);
        $this->setCourseInstructors($course_id, $data['instructor_ids'] ?? []);
    }

    public function approve(int $course_id): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_course` SET status = 'published', published_at = IFNULL(published_at, NOW()), date_modified = NOW() WHERE course_id = '" . (int)$course_id . "'");
    }

    public function delete(int $course_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_course` WHERE course_id = '" . (int)$course_id . "'");
    }

    public function getCourse(int $course_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE course_id = '" . (int)$course_id . "'");
        $course = $query->row ?? [];
        if ($course) {
            $course['category_ids'] = $this->getCourseCategoryIds($course_id);
            $course['instructor_ids'] = $this->getCourseInstructorIds($course_id);
        }
        return $course;
    }

    public function getCourses(array $filter = []): array {
        $sql = "SELECT c.*,
                GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name SEPARATOR ', ') AS categories,
                GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
                FROM `" . DB_PREFIX . "mooc_course` c
                LEFT JOIN `" . DB_PREFIX . "mooc_course_category` cc ON cc.course_id = c.course_id
                LEFT JOIN `" . DB_PREFIX . "mooc_category` cat ON cat.category_id = cc.category_id
                LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
                LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
                WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND c.status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $sql .= " GROUP BY c.course_id";
        $sql .= " ORDER BY c.date_added DESC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function setCourseCategories(int $course_id, array $category_ids): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_course_category` WHERE course_id = '" . (int)$course_id . "'");
        $category_ids = array_unique(array_filter(array_map('intval', $category_ids)));
        foreach ($category_ids as $category_id) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_course_category` SET course_id = '" . (int)$course_id . "', category_id = '" . (int)$category_id . "'");
        }
    }

    public function setCourseInstructors(int $course_id, array $instructor_ids): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_course_instructor` WHERE course_id = '" . (int)$course_id . "'");
        $instructor_ids = array_unique(array_filter(array_map('intval', $instructor_ids)));
        foreach ($instructor_ids as $instructor_id) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_course_instructor` SET course_id = '" . (int)$course_id . "', instructor_id = '" . (int)$instructor_id . "'");
        }
    }

    public function getCourseCategoryIds(int $course_id): array {
        $rows = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "mooc_course_category` WHERE course_id = '" . (int)$course_id . "'")->rows;
        return array_map(fn($r) => (int)$r['category_id'], $rows);
    }

    public function getCourseInstructorIds(int $course_id): array {
        $rows = $this->db->query("SELECT instructor_id FROM `" . DB_PREFIX . "mooc_course_instructor` WHERE course_id = '" . (int)$course_id . "'")->rows;
        return array_map(fn($r) => (int)$r['instructor_id'], $rows);
    }

    public function getAllCategories(): array {
        return $this->db->query("SELECT category_id, name FROM `" . DB_PREFIX . "mooc_category` ORDER BY name ASC")->rows;
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
