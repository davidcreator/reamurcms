<?php
namespace Reamur\Catalog\Model\Cms;

class MoocLesson extends \Reamur\System\Engine\Model {
    public function getLessonsByCourse(int $course_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_lesson` WHERE course_id = '" . (int)$course_id . "' AND status = 1 ORDER BY sort_order ASC, lesson_id ASC");
        return $query->rows;
    }

    public function getLesson(int $lesson_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_lesson` WHERE lesson_id = '" . (int)$lesson_id . "' AND status = 1");
        return $query->row ?? [];
    }

    public function getLessonContent(int $lesson_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_lesson_content` WHERE lesson_id = '" . (int)$lesson_id . "' LIMIT 1");
        return $query->row ?? [];
    }
}
