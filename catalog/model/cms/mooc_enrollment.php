<?php
namespace Reamur\Catalog\Model\Cms;

class MoocEnrollment extends \Reamur\System\Engine\Model {
    public function ensureColumns(): void {
        $col = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_enrollment` LIKE 'final_score'")->num_rows;
        if (!$col) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_enrollment` ADD `final_score` DECIMAL(5,2) DEFAULT NULL AFTER `progress_percent`, ADD `time_spent_seconds` INT(11) NOT NULL DEFAULT 0 AFTER `final_score`");
        }
        $col2 = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_progress` LIKE 'time_spent_seconds'")->num_rows;
        if (!$col2) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_progress` ADD `time_spent_seconds` INT(11) NOT NULL DEFAULT 0 AFTER `status`, ADD `score` DECIMAL(5,2) DEFAULT NULL AFTER `time_spent_seconds`");
        }
    }

    public function getEnrollment(int $course_id, int $customer_id): array {
        $this->ensureColumns();
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_enrollment` WHERE course_id = '" . (int)$course_id . "' AND customer_id = '" . (int)$customer_id . "' LIMIT 1");
        return $query->row ?? [];
    }

    public function enroll(int $course_id, int $customer_id): int {
        $this->ensureColumns();
        $existing = $this->getEnrollment($course_id, $customer_id);
        if ($existing) {
            return (int)$existing['enrollment_id'];
        }

        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_enrollment` SET
            course_id = '" . (int)$course_id . "',
            customer_id = '" . (int)$customer_id . "',
            status = 'active',
            progress_percent = 0,
            final_score = NULL,
            time_spent_seconds = 0,
            started_at = NOW(),
            completed_at = NULL");

        return (int)$this->db->getLastId();
    }

    public function getEnrollmentsByCustomer(int $customer_id): array {
        $this->ensureColumns();
        $query = $this->db->query("SELECT e.*, c.title, c.slug, c.duration_minutes, c.featured_image
            FROM `" . DB_PREFIX . "mooc_enrollment` e
            JOIN `" . DB_PREFIX . "mooc_course` c ON e.course_id = c.course_id
            WHERE e.customer_id = '" . (int)$customer_id . "'
            ORDER BY e.started_at DESC");
        return $query->rows;
    }

    public function updateLessonProgress(int $course_id, int $customer_id, int $lesson_id, string $status, int $time_spent_seconds = 0, $score = null): void {
        $this->ensureColumns();
        $enrollment = $this->getEnrollment($course_id, $customer_id);
        if (!$enrollment) return;
        $enrollment_id = (int)$enrollment['enrollment_id'];

        $existing = $this->db->query("SELECT progress_id, time_spent_seconds FROM `" . DB_PREFIX . "mooc_progress` WHERE enrollment_id = '" . $enrollment_id . "' AND lesson_id = '" . (int)$lesson_id . "'")->row;
        if ($existing) {
            $new_time = (int)$existing['time_spent_seconds'] + max(0, $time_spent_seconds);
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_progress` SET
                status = '" . $this->db->escape($status) . "',
                time_spent_seconds = '" . $new_time . "',
                score = " . ($score === null ? "NULL" : (float)$score) . ",
                last_viewed_at = NOW(),
                completed_at = " . ($status === 'completed' ? "NOW()" : "completed_at") . "
                WHERE progress_id = '" . (int)$existing['progress_id'] . "'");
        } else {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_progress` SET
                enrollment_id = '" . $enrollment_id . "',
                lesson_id = '" . (int)$lesson_id . "',
                status = '" . $this->db->escape($status) . "',
                time_spent_seconds = '" . max(0, $time_spent_seconds) . "',
                score = " . ($score === null ? "NULL" : (float)$score) . ",
                last_viewed_at = NOW(),
                completed_at = " . ($status === 'completed' ? "NOW()" : "NULL") . ")");
        }

        $this->recalculateProgress($enrollment_id);
    }

    public function getLessonProgresses(int $course_id, int $customer_id): array {
        $enrollment = $this->getEnrollment($course_id, $customer_id);
        if (!$enrollment) return [];
        $rows = $this->db->query("SELECT lesson_id, status, time_spent_seconds, score FROM `" . DB_PREFIX . "mooc_progress` WHERE enrollment_id = '" . (int)$enrollment['enrollment_id'] . "'")->rows;
        $out = [];
        foreach ($rows as $row) {
            $out[(int)$row['lesson_id']] = $row;
        }
        return $out;
    }

    private function recalculateProgress(int $enrollment_id): void {
        $row = $this->db->query("SELECT course_id FROM `" . DB_PREFIX . "mooc_enrollment` WHERE enrollment_id = '" . (int)$enrollment_id . "'")->row;
        if (!$row) return;
        $course_id = (int)$row['course_id'];
        $total_lessons = (int)$this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_lesson` WHERE course_id = '" . $course_id . "' AND status = 1")->row['total'];
        if ($total_lessons <= 0) {
            $this->db->query("UPDATE `" . DB_PREFIX . "mooc_enrollment` SET progress_percent = 0 WHERE enrollment_id = '" . $enrollment_id . "'");
            return;
        }

        $completed = (int)$this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_progress` WHERE enrollment_id = '" . $enrollment_id . "' AND status = 'completed'")->row['total'];
        $progress_percent = (int)round(($completed / $total_lessons) * 100);

        $sum_time = (int)$this->db->query("SELECT SUM(time_spent_seconds) AS t FROM `" . DB_PREFIX . "mooc_progress` WHERE enrollment_id = '" . $enrollment_id . "'")->row['t'];
        $avg_score_row = $this->db->query("SELECT AVG(score) AS avg_score FROM `" . DB_PREFIX . "mooc_progress` WHERE enrollment_id = '" . $enrollment_id . "' AND score IS NOT NULL")->row;
        $final_score = $avg_score_row && $avg_score_row['avg_score'] !== null ? $avg_score_row['avg_score'] : null;

        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_enrollment` SET
            progress_percent = '" . $progress_percent . "',
            time_spent_seconds = '" . $sum_time . "',
            final_score = " . ($final_score === null ? "NULL" : (float)$final_score) . ",
            completed_at = " . ($progress_percent === 100 ? "IFNULL(completed_at, NOW())" : "NULL") . "
            WHERE enrollment_id = '" . $enrollment_id . "'");

        if ($progress_percent === 100) {
            $this->ensureCertificate($enrollment_id);
        }
    }

    private function ensureCertificate(int $enrollment_id): void {
        $exists = $this->db->query("SELECT certificate_id FROM `" . DB_PREFIX . "mooc_certificate` WHERE enrollment_id = '" . $enrollment_id . "'")->row;
        if ($exists) return;

        $code = strtoupper(bin2hex(random_bytes(4))) . '-' . dechex(time());

        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_certificate` SET
            enrollment_id = '" . $enrollment_id . "',
            certificate_code = '" . $this->db->escape($code) . "',
            issued_at = NOW()");
    }

    public function ensureCertificateForEnrollment(int $enrollment_id): void {
        $this->ensureColumns();
        $this->ensureCertificate($enrollment_id);
    }

    public function getCertificateByCode(string $code): array {
        $query = $this->db->query("SELECT cert.*, e.course_id, e.customer_id, e.completed_at, c.title AS course_title, c.duration_minutes,
            GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
            FROM `" . DB_PREFIX . "mooc_certificate` cert
            JOIN `" . DB_PREFIX . "mooc_enrollment` e ON e.enrollment_id = cert.enrollment_id
            JOIN `" . DB_PREFIX . "mooc_course` c ON c.course_id = e.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
            WHERE cert.certificate_code = '" . $this->db->escape($code) . "'
            GROUP BY cert.certificate_id");
        return $query->row ?? [];
    }
}
