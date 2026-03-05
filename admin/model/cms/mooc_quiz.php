<?php
namespace Reamur\Admin\Model\Cms;

class MoocQuiz extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('mooc_installer');
        $installer = new \MoocInstaller($this->db);
        if (!$installer->moocTablesExist()) {
            $installer->installMoocTables();
        }
        $this->ensureColumns();
    }

    private function ensureColumns(): void {
        $col = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_quiz_question` LIKE 'manual_review'")->num_rows;
        if (!$col) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_quiz_question`
                ADD `manual_review` TINYINT(1) NOT NULL DEFAULT 0 AFTER `points`,
                MODIFY `type` enum('single','multiple','true_false','text','file') NOT NULL DEFAULT 'single'");
        }
        $col2 = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "mooc_quiz_answer` LIKE 'attachment'")->num_rows;
        if (!$col2) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "mooc_quiz_answer` ADD `attachment` VARCHAR(255) DEFAULT NULL AFTER `selected_answer`");
        }
    }

    public function add(array $data): int {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_quiz` SET
            lesson_id = '" . (int)$data['lesson_id'] . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            passing_score = '" . (int)($data['passing_score'] ?? 70) . "',
            time_limit_seconds = " . ($data['time_limit_seconds'] ? (int)$data['time_limit_seconds'] : "NULL") . ",
            status = '" . (int)($data['status'] ?? 1) . "'");
        $quiz_id = (int)$this->db->getLastId();
        $this->setQuestions($quiz_id, $data['questions'] ?? []);
        return $quiz_id;
    }

    public function edit(int $quiz_id, array $data): void {
        $this->db->query("UPDATE `" . DB_PREFIX . "mooc_quiz` SET
            lesson_id = '" . (int)$data['lesson_id'] . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            description = '" . $this->db->escape((string)($data['description'] ?? '')) . "',
            passing_score = '" . (int)($data['passing_score'] ?? 70) . "',
            time_limit_seconds = " . ($data['time_limit_seconds'] ? (int)$data['time_limit_seconds'] : "NULL") . ",
            status = '" . (int)($data['status'] ?? 1) . "'
            WHERE quiz_id = '" . (int)$quiz_id . "'");
        $this->setQuestions($quiz_id, $data['questions'] ?? []);
    }

    public function delete(int $quiz_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_quiz` WHERE quiz_id = '" . (int)$quiz_id . "'");
    }

    public function getQuiz(int $quiz_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_quiz` WHERE quiz_id = '" . (int)$quiz_id . "'");
        $quiz = $query->row ?? [];
        if ($quiz) {
            $quiz['questions'] = $this->getQuestions($quiz_id);
        }
        return $quiz;
    }

    public function getQuizzes(array $filter = []): array {
        $sql = "SELECT q.*, l.title AS lesson_title FROM `" . DB_PREFIX . "mooc_quiz` q
                LEFT JOIN `" . DB_PREFIX . "mooc_lesson` l ON (q.lesson_id = l.lesson_id)
                WHERE 1";
        if (!empty($filter['lesson_id'])) {
            $sql .= " AND q.lesson_id = '" . (int)$filter['lesson_id'] . "'";
        }
        $sql .= " ORDER BY q.quiz_id DESC";
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getTotalQuizzes(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "mooc_quiz` WHERE 1";
        if (!empty($filter['lesson_id'])) {
            $sql .= " AND lesson_id = '" . (int)$filter['lesson_id'] . "'";
        }
        return (int)$this->db->query($sql)->row['total'];
    }

    public function setQuestions(int $quiz_id, array $questions): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "mooc_quiz_question` WHERE quiz_id = '" . (int)$quiz_id . "'");
        $i = 0;
        foreach ($questions as $q) {
            if (empty($q['question'])) {
                continue;
            }
            $type = $q['type'] ?? 'single';
            $options = $q['options'] ?? '';
            if (is_array($options)) {
                $options = implode("\n", $options);
            }
            $correct = $q['correct_answer'] ?? '';
            if (is_array($correct)) {
                $correct = implode("\n", $correct);
            }
            $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_quiz_question` SET
                quiz_id = '" . (int)$quiz_id . "',
                type = '" . $this->db->escape((string)$type) . "',
                question = '" . $this->db->escape((string)$q['question']) . "',
                options = '" . $this->db->escape((string)$options) . "',
                correct_answer = '" . $this->db->escape((string)$correct) . "',
                points = '" . (int)($q['points'] ?? 1) . "',
                manual_review = '" . (int)($q['manual_review'] ?? 0) . "',
                sort_order = '" . (int)($q['sort_order'] ?? $i) . "'");
            $i++;
        }
    }

    public function getQuestions(int $quiz_id): array {
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "mooc_quiz_question` WHERE quiz_id = '" . (int)$quiz_id . "' ORDER BY sort_order ASC, question_id ASC")->rows;
    }
}
