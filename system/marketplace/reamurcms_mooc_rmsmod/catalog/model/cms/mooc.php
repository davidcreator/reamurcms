<?php
namespace Reamur\Catalog\Model\Cms;

class Mooc extends \Reamur\System\Engine\Model {
    public function getCourses(array $data = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE status = 'published'";
        $sql .= " ORDER BY published_at DESC NULLS LAST, date_added DESC";
        $start = (int)($data['start'] ?? 0);
        $limit = (int)($data['limit'] ?? 10);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 10;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getCourse(int $course_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE course_id = '" . (int)$course_id . "' AND status = 'published'");
        return $query->row ?? [];
    }

    public function getCourseBySlug(string $slug): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_course` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 'published'");
        return $query->row ?? [];
    }
}
