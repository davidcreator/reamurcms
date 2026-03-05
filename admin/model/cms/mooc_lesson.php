<?php
namespace Reamur\Admin\Model\Cms;

class MoocLesson extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('mooc_installer');
        $installer = new \MoocInstaller($this->db);
        if (!$installer->moocTablesExist()) {
            $installer->installMoocTables();
        }
        $this->ensureColumns();
    }

    private function ensureColumns(): void {
        $cols = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_lesson` LIKE 'min_seconds'")->num_rows;
        if (!$cols) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_lesson`
                ADD `external_url` varchar(255) DEFAULT NULL AFTER `video_url`,
                ADD `min_seconds` int(11) NOT NULL DEFAULT 0 AFTER `duration_minutes`,
                ADD `auto_complete` tinyint(1) NOT NULL DEFAULT 0 AFTER `min_seconds`,
                ADD `comments_enabled` tinyint(1) NOT NULL DEFAULT 1 AFTER `auto_complete`,
                MODIFY `content_type` enum('video','article','quiz','live','slides','pdf','link','download') NOT NULL DEFAULT 'article'");
        }
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_lesson` SET
            course_id = '" . (int)$data['course_id'] . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            slug = '" . $this->db->escape((string)($data['slug'] ?? '')) . "',
            summary = '" . $this->db->escape((string)($data['summary'] ?? '')) . "',
            content_type = '" . $this->db->escape((string)($data['content_type'] ?? 'video')) . "',
            video_url = '" . $this->db->escape((string)($data['video_url'] ?? '')) . "',
            external_url = '" . $this->db->escape((string)($data['external_url'] ?? '')) . "',
            duration_minutes = '" . (int)($data['duration_minutes'] ?? 0) . "',
            min_seconds = '" . (int)($data['min_seconds'] ?? 0) . "',
            auto_complete = '" . (int)($data['auto_complete'] ?? 0) . "',
            comments_enabled = '" . (int)($data['comments_enabled'] ?? 1) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            release_at = " . ($data['release_at'] ? "'" . $this->db->escape((string)$data['release_at']) . "'" : "NULL") . ",
            date_added = NOW(),
            date_modified = NOW()");

        $lesson_id = (int)$this->db->getLastId();

        $this->upsertContent($lesson_id, $data);

        return $lesson_id;
    }

    public function edit(int $lesson_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_lesson` SET
            course_id = '" . (int)$data['course_id'] . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            slug = '" . $this->db->escape((string)($data['slug'] ?? '')) . "',
            summary = '" . $this->db->escape((string)($data['summary'] ?? '')) . "',
            content_type = '" . $this->db->escape((string)($data['content_type'] ?? 'video')) . "',
            video_url = '" . $this->db->escape((string)($data['video_url'] ?? '')) . "',
            external_url = '" . $this->db->escape((string)($data['external_url'] ?? '')) . "',
            duration_minutes = '" . (int)($data['duration_minutes'] ?? 0) . "',
            min_seconds = '" . (int)($data['min_seconds'] ?? 0) . "',
            auto_complete = '" . (int)($data['auto_complete'] ?? 0) . "',
            comments_enabled = '" . (int)($data['comments_enabled'] ?? 1) . "',
            sort_order = '" . (int)($data['sort_order'] ?? 0) . "',
            status = '" . (int)($data['status'] ?? 1) . "',
            release_at = " . ($data['release_at'] ? "'" . $this->db->escape((string)$data['release_at']) . "'" : "NULL") . ",
            date_modified = NOW()
            WHERE lesson_id = '" . (int)$lesson_id . "'");

        $this->upsertContent($lesson_id, $data);
    }

    public function delete(int $lesson_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_lesson` WHERE lesson_id = '" . (int)$lesson_id . "'");
    }

    public function getLesson(int $lesson_id): array {
        $lesson = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_lesson` WHERE lesson_id = '" . (int)$lesson_id . "'")->row ?? [];
        if (!$lesson) {
            return [];
        }
        $content = $this->getLessonContent($lesson_id);
        return array_merge($lesson, $content);
    }

    public function getLessons(array $filter = []): array {
        $sql = "SELECT l.*, c.title AS course_title FROM `" . DB_PREFIX . "mooc_lesson` l
                LEFT JOIN `" . DB_PREFIX . "mooc_course` c ON (l.course_id = c.course_id)
                WHERE 1";
        if (!empty($filter['course_id'])) {
            $sql .= " AND l.course_id = '" . (int)$filter['course_id'] . "'";
        }
        $sql .= " ORDER BY l.course_id ASC, l.sort_order ASC, l.lesson_id ASC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getTotalLessons(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_lesson` WHERE 1";
        if (!empty($filter['course_id'])) {
            $sql .= " AND course_id = '" . (int)$filter['course_id'] . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    private function upsertContent(int $lesson_id, array $data): void {
        $content = [
            'content' => $data['content'] ?? '',
            'resources' => $data['resources'] ?? '',
            'attachment' => $data['attachment'] ?? ''
        ];

        $exists = $this->db->query("SELECT content_id FROM `" . DB_PREFIX . "mooc_lesson_content` WHERE lesson_id = '" . (int)$lesson_id . "'")->row;

        if ($exists) {
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_lesson_content` SET
                content = '" . $this->db->escape((string)$content['content']) . "',
                resources = '" . $this->db->escape((string)$content['resources']) . "',
                attachment = '" . $this->db->escape((string)$content['attachment']) . "'
                WHERE lesson_id = '" . (int)$lesson_id . "'");
        } else {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_lesson_content` SET
                lesson_id = '" . (int)$lesson_id . "',
                content = '" . $this->db->escape((string)$content['content']) . "',
                resources = '" . $this->db->escape((string)$content['resources']) . "',
                attachment = '" . $this->db->escape((string)$content['attachment']) . "'");
        }
    }

    private function getLessonContent(int $lesson_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_lesson_content` WHERE lesson_id = '" . (int)$lesson_id . "' LIMIT 1");
        return $query->row ?? [];
    }
}
