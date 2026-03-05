<?php
namespace Reamur\Catalog\Model\Cms;

class Mooc extends \Reamur\System\Engine\Model {
    public function getCourses(array $data = []): array {
        $sql = "SELECT c.*,
                GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name SEPARATOR ', ') AS categories,
                GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
                FROM `" . DB_PREFIX . "mooc_course` c
                LEFT JOIN `" . DB_PREFIX . "mooc_course_category` cc ON cc.course_id = c.course_id
                LEFT JOIN `" . DB_PREFIX . "mooc_category` cat ON cat.category_id = cc.category_id
                LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
                LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
                WHERE c.status = 'published'";
        $sql .= " GROUP BY c.course_id";
        $sql .= " ORDER BY (c.published_at IS NULL), c.published_at DESC, c.date_added DESC";
        $start = (int)($data['start'] ?? 0);
        $limit = (int)($data['limit'] ?? 10);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 10;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getCourse(int $course_id): array {
        $query = $this->db->query("SELECT c.*,
            GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name SEPARATOR ', ') AS categories,
            GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
            FROM `" . DB_PREFIX . "mooc_course` c
            LEFT JOIN `" . DB_PREFIX . "mooc_course_category` cc ON cc.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_category` cat ON cat.category_id = cc.category_id
            LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
            WHERE c.course_id = '" . (int)$course_id . "' AND c.status = 'published'
            GROUP BY c.course_id");
        return $query->row ?? [];
    }

    public function getCourseBySlug(string $slug): array {
        $query = $this->db->query("SELECT c.*,
            GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name SEPARATOR ', ') AS categories,
            GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
            FROM `" . DB_PREFIX . "mooc_course` c
            LEFT JOIN `" . DB_PREFIX . "mooc_course_category` cc ON cc.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_category` cat ON cat.category_id = cc.category_id
            LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
            WHERE c.slug = '" . $this->db->escape($slug) . "' AND c.status = 'published'
            GROUP BY c.course_id");
        return $query->row ?? [];
    }
}
