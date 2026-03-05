<?php
namespace Reamur\Catalog\Model\Cms;

class MoocGamification extends \Reamur\System\Engine\Model {
    private function ensureTables(): void {
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_points'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "mooc_points` (
                `customer_id` int(11) NOT NULL,
                `points` int(11) NOT NULL DEFAULT 0,
                `updated_at` datetime NOT NULL,
                PRIMARY KEY (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_streak'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "mooc_streak` (
                `customer_id` int(11) NOT NULL,
                `current_streak` int(11) NOT NULL DEFAULT 0,
                `max_streak` int(11) NOT NULL DEFAULT 0,
                `last_activity_date` date DEFAULT NULL,
                PRIMARY KEY (`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_badge'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "mooc_badge` (
                `badge_id` int(11) NOT NULL AUTO_INCREMENT,
                `code` varchar(64) NOT NULL,
                `name` varchar(255) NOT NULL,
                `description` varchar(255) DEFAULT NULL,
                `icon` varchar(255) DEFAULT NULL,
                `active` tinyint(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`badge_id`),
                UNIQUE KEY `code` (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
        $exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_badge_unlock'")->num_rows;
        if (!$exists) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "mooc_badge_unlock` (
                `unlock_id` int(11) NOT NULL AUTO_INCREMENT,
                `badge_id` int(11) NOT NULL,
                `customer_id` int(11) NOT NULL,
                `unlocked_at` datetime NOT NULL,
                PRIMARY KEY (`unlock_id`),
                UNIQUE KEY `badge_customer` (`badge_id`,`customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
        $this->seedBadges();
    }

    private function seedBadges(): void {
        $badges = [
            ['first_course','Primeiro Curso','Completou o primeiro curso','badge-first-course'],
            ['courses_5','5 Cursos','Concluiu 5 cursos','badge-5-courses'],
            ['lessons_10','10 Aulas','Concluiu 10 aulas','badge-10-lessons'],
            ['lessons_50','50 Aulas','Concluiu 50 aulas','badge-50-lessons'],
            ['streak_7','7 Dias Seguidos','Estudou 7 dias seguidos','badge-streak-7'],
            ['streak_30','30 Dias Seguidos','Estudou 30 dias seguidos','badge-streak-30']
        ];
        foreach ($badges as $b) {
            $this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "mooc_badge` SET code='" . $this->db->escape($b[0]) . "', name='" . $this->db->escape($b[1]) . "', description='" . $this->db->escape($b[2]) . "', icon='" . $this->db->escape($b[3]) . "'");
        }
    }

    public function addPoints(int $customer_id, int $points): void {
        $this->ensureTables();
        $points = max(0, $points);
        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_points` SET customer_id = '" . (int)$customer_id . "', points = '" . $points . "', updated_at = NOW()
            ON DUPLICATE KEY UPDATE points = points + VALUES(points), updated_at = NOW()");
    }

    public function touchStreak(int $customer_id): void {
        $this->ensureTables();
        $row = $this->db->query("SELECT current_streak, max_streak, last_activity_date FROM `" . DB_PREFIX . "mooc_streak` WHERE customer_id = '" . (int)$customer_id . "'")->row;
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $current = (int)($row['current_streak'] ?? 0);
        $max = (int)($row['max_streak'] ?? 0);
        $last = $row['last_activity_date'] ?? null;

        if ($last === $today) {
            return;
        } elseif ($last === $yesterday) {
            $current++;
        } else {
            $current = 1;
        }
        $max = max($max, $current);

        $this->db->query("INSERT INTO `" . DB_PREFIX . "mooc_streak` SET customer_id = '" . (int)$customer_id . "', current_streak = '" . $current . "', max_streak = '" . $max . "', last_activity_date = '" . $this->db->escape($today) . "'
            ON DUPLICATE KEY UPDATE current_streak = VALUES(current_streak), max_streak = VALUES(max_streak), last_activity_date = VALUES(last_activity_date)");
    }

    public function completeLesson(int $customer_id, int $course_id, int $lesson_id): void {
        $this->touchStreak($customer_id);
        $this->addPoints($customer_id, 10);
        $this->checkBadges($customer_id);
    }

    public function completeCourse(int $customer_id, int $course_id): void {
        $this->touchStreak($customer_id);
        $this->addPoints($customer_id, 100);
        $this->checkBadges($customer_id);
    }

    private function awardBadge(string $code, int $customer_id): void {
        $badge = $this->db->query("SELECT badge_id FROM `" . DB_PREFIX . "mooc_badge` WHERE code = '" . $this->db->escape($code) . "' AND active = 1")->row;
        if (!$badge) return;
        $this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "mooc_badge_unlock` SET badge_id = '" . (int)$badge['badge_id'] . "', customer_id = '" . (int)$customer_id . "', unlocked_at = NOW()");
    }

    public function checkBadges(int $customer_id): void {
        $this->ensureTables();
        $courses_completed = (int)$this->db->query("SELECT COUNT(*) AS c FROM `" . DB_PREFIX . "mooc_enrollment` WHERE customer_id = '" . (int)$customer_id . "' AND progress_percent >= 100")->row['c'];
        $lessons_completed = (int)$this->db->query("SELECT COUNT(*) AS c FROM `" . DB_PREFIX . "mooc_progress` p JOIN `" . DB_PREFIX . "mooc_enrollment` e ON e.enrollment_id = p.enrollment_id WHERE e.customer_id = '" . (int)$customer_id . "' AND p.status = 'completed'")->row['c'];
        $streak = (int)($this->db->query("SELECT current_streak FROM `" . DB_PREFIX . "mooc_streak` WHERE customer_id = '" . (int)$customer_id . "'")->row['current_streak'] ?? 0);

        if ($courses_completed >= 1) $this->awardBadge('first_course', $customer_id);
        if ($courses_completed >= 5) $this->awardBadge('courses_5', $customer_id);
        if ($lessons_completed >= 10) $this->awardBadge('lessons_10', $customer_id);
        if ($lessons_completed >= 50) $this->awardBadge('lessons_50', $customer_id);
        if ($streak >= 7) $this->awardBadge('streak_7', $customer_id);
        if ($streak >= 30) $this->awardBadge('streak_30', $customer_id);
    }

    public function getStats(int $customer_id): array {
        $this->ensureTables();
        $points = (int)($this->db->query("SELECT points FROM `" . DB_PREFIX . "mooc_points` WHERE customer_id = '" . (int)$customer_id . "'")->row['points'] ?? 0);
        $streak_row = $this->db->query("SELECT current_streak, max_streak, last_activity_date FROM `" . DB_PREFIX . "mooc_streak` WHERE customer_id = '" . (int)$customer_id . "'")->row;
        $badges = $this->getBadges($customer_id);
        return [
            'points' => $points,
            'current_streak' => (int)($streak_row['current_streak'] ?? 0),
            'max_streak' => (int)($streak_row['max_streak'] ?? 0),
            'badges' => $badges
        ];
    }

    public function getBadges(int $customer_id): array {
        $this->ensureTables();
        $query = $this->db->query("SELECT b.code, b.name, b.description, b.icon, u.unlocked_at FROM `" . DB_PREFIX . "mooc_badge_unlock` u JOIN `" . DB_PREFIX . "mooc_badge` b ON b.badge_id = u.badge_id WHERE u.customer_id = '" . (int)$customer_id . "' ORDER BY u.unlocked_at DESC");
        return $query->rows;
    }

    public function getLeaderboard(int $limit = 10): array {
        $this->ensureTables();
        $query = $this->db->query("SELECT p.customer_id, p.points, c.firstname, c.lastname FROM `" . DB_PREFIX . "mooc_points` p JOIN `" . DB_PREFIX . "customer` c ON c.customer_id = p.customer_id ORDER BY p.points DESC, p.updated_at ASC LIMIT " . (int)$limit);
        return $query->rows;
    }

    public function getGoals(int $customer_id): array {
        $this->ensureTables();
        $week_lessons = (int)$this->db->query("SELECT COUNT(*) AS c FROM `" . DB_PREFIX . "mooc_progress` p JOIN `" . DB_PREFIX . "mooc_enrollment` e ON e.enrollment_id = p.enrollment_id WHERE e.customer_id = '" . (int)$customer_id . "' AND p.status='completed' AND p.completed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->row['c'];
        $month_courses = (int)$this->db->query("SELECT COUNT(*) AS c FROM `" . DB_PREFIX . "mooc_enrollment` WHERE customer_id = '" . (int)$customer_id . "' AND progress_percent >= 100 AND completed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->row['c'];
        return [
            [
                'title' => 'Completar 5 aulas nesta semana',
                'progress' => $week_lessons,
                'target' => 5,
                'percent' => min(100, ($week_lessons / 5) * 100)
            ],
            [
                'title' => 'Concluir 1 curso neste mês',
                'progress' => $month_courses,
                'target' => 1,
                'percent' => min(100, ($month_courses / 1) * 100)
            ]
        ];
    }
}
