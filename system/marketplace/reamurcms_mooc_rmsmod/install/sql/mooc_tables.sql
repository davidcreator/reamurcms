-- -----------------------------------------------------------
-- ReamurCMS MOOC Extension Schema
-- -----------------------------------------------------------
SET sql_mode = '';
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `rms_mooc_certificate`;
DROP TABLE IF EXISTS `rms_mooc_progress`;
DROP TABLE IF EXISTS `rms_mooc_quiz_answer`;
DROP TABLE IF EXISTS `rms_mooc_quiz_question`;
DROP TABLE IF EXISTS `rms_mooc_quiz`;
DROP TABLE IF EXISTS `rms_mooc_lesson_content`;
DROP TABLE IF EXISTS `rms_mooc_lesson`;
DROP TABLE IF EXISTS `rms_mooc_course_category`;
DROP TABLE IF EXISTS `rms_mooc_course_instructor`;
DROP TABLE IF EXISTS `rms_mooc_enrollment`;
DROP TABLE IF EXISTS `rms_mooc_course`;
DROP TABLE IF EXISTS `rms_mooc_category`;
DROP TABLE IF EXISTS `rms_mooc_instructor`;

CREATE TABLE `rms_mooc_instructor` (
  `instructor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`instructor_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `rms_mooc_instructor_user_fk` FOREIGN KEY (`user_id`) REFERENCES `rms_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `objectives` text DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced','all') NOT NULL DEFAULT 'all',
  `language` varchar(10) DEFAULT 'en',
  `duration_minutes` int(11) NOT NULL DEFAULT 0,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `featured_image` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_course_instructor` (
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`, `instructor_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `rms_mooc_ci_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_ci_instructor_fk` FOREIGN KEY (`instructor_id`) REFERENCES `rms_mooc_instructor` (`instructor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_course_category` (
  `course_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`, `category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `rms_mooc_cc_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_cc_category_fk` FOREIGN KEY (`category_id`) REFERENCES `rms_mooc_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_lesson` (
  `lesson_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content_type` enum('video','article','quiz','live','slides','pdf','link','download') NOT NULL DEFAULT 'article',
  `video_url` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 0,
  `min_seconds` int(11) NOT NULL DEFAULT 0,
  `auto_complete` tinyint(1) NOT NULL DEFAULT 0,
  `comments_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(5) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `release_at` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`lesson_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `rms_mooc_lesson_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_lesson_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `resources` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `rms_mooc_lesson_content_fk` FOREIGN KEY (`lesson_id`) REFERENCES `rms_mooc_lesson` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_quiz` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `passing_score` int(11) NOT NULL DEFAULT 70,
  `time_limit_seconds` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`quiz_id`),
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `rms_mooc_quiz_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `rms_mooc_lesson` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_quiz_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `type` enum('single','multiple','true_false','text','file') NOT NULL DEFAULT 'single',
  `question` text NOT NULL,
  `options` longtext DEFAULT NULL,
  `correct_answer` longtext DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `manual_review` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`question_id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `rms_mooc_question_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `rms_mooc_quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_quiz_answer` (
  `answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `selected_answer` longtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `score` int(11) NOT NULL DEFAULT 0,
  `answered_at` datetime NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `question_id` (`question_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_answer_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `rms_mooc_quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_answer_question_fk` FOREIGN KEY (`question_id`) REFERENCES `rms_mooc_quiz_question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_answer_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_enrollment` (
  `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('active','completed','cancelled','refunded') NOT NULL DEFAULT 'active',
  `progress_percent` int(3) NOT NULL DEFAULT 0,
  `final_score` decimal(5,2) DEFAULT NULL,
  `time_spent_seconds` int(11) NOT NULL DEFAULT 0,
  `started_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`enrollment_id`),
  KEY `course_id` (`course_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_enrollment_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_enrollment_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_progress` (
  `progress_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `enrollment_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `status` enum('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  `time_spent_seconds` int(11) NOT NULL DEFAULT 0,
  `score` decimal(5,2) DEFAULT NULL,
  `last_viewed_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`progress_id`),
  KEY `enrollment_id` (`enrollment_id`),
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `rms_mooc_progress_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `rms_mooc_enrollment` (`enrollment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_progress_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `rms_mooc_lesson` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_certificate` (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_id` int(11) NOT NULL,
  `certificate_code` varchar(64) NOT NULL,
  `issued_at` datetime NOT NULL,
  PRIMARY KEY (`certificate_id`),
  UNIQUE KEY `certificate_code` (`certificate_code`),
  KEY `enrollment_id` (`enrollment_id`),
  CONSTRAINT `rms_mooc_certificate_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `rms_mooc_enrollment` (`enrollment_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_points` (
  `customer_id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `rms_mooc_points_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_streak` (
  `customer_id` int(11) NOT NULL,
  `current_streak` int(11) NOT NULL DEFAULT 0,
  `max_streak` int(11) NOT NULL DEFAULT 0,
  `last_activity_date` date DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `rms_mooc_streak_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_badge` (
  `badge_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`badge_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_badge_unlock` (
  `unlock_id` int(11) NOT NULL AUTO_INCREMENT,
  `badge_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `unlocked_at` datetime NOT NULL,
  PRIMARY KEY (`unlock_id`),
  UNIQUE KEY `badge_customer` (`badge_id`,`customer_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_badge_unlock_badge_fk` FOREIGN KEY (`badge_id`) REFERENCES `rms_mooc_badge` (`badge_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_badge_unlock_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_goal` (
  `goal_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `goal_type` varchar(64) NOT NULL,
  `target_value` int(11) NOT NULL,
  `progress_value` int(11) NOT NULL DEFAULT 0,
  `status` enum('open','completed') NOT NULL DEFAULT 'open',
  `created_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`goal_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_goal_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_mooc_badge` (`code`,`name`,`description`,`icon`) VALUES
('first_course','Primeiro Curso','Completou o primeiro curso','badge-first-course'),
('courses_5','5 Cursos','Concluiu 5 cursos','badge-5-courses'),
('lessons_10','10 Aulas','Concluiu 10 aulas','badge-10-lessons'),
('lessons_50','50 Aulas','Concluiu 50 aulas','badge-50-lessons'),
('streak_7','7 Dias Seguidos','Estudou 7 dias seguidos','badge-streak-7'),
('streak_30','30 Dias Seguidos','Estudou 30 dias seguidos','badge-streak-30');

CREATE TABLE `rms_mooc_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `method` varchar(64) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `transaction_ref` varchar(128) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `course_id` (`course_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_payment_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_payment_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_mooc_notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `channel` enum('system','email','push') NOT NULL DEFAULT 'system',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(512) DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `customer_id` (`customer_id`),
  KEY `course_id` (`course_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `channel` (`channel`),
  CONSTRAINT `rms_mooc_notification_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_notification_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_notification_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `rms_mooc_lesson` (`lesson_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
CREATE TABLE `rms_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `context` varchar(64) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `method` varchar(64) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'BRL',
  `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `transaction_ref` varchar(128) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `customer_id` (`customer_id`),
  KEY `context_ref` (`context`,`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_subscription_plan` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'BRL',
  `period_days` int(11) NOT NULL DEFAULT 30,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`plan_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rms_subscription` (
  `subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `plan_id` (`plan_id`),
  KEY `customer_id` (`customer_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `rms_mooc_instructor`
  ADD COLUMN `stripe_account_id` varchar(64) DEFAULT NULL,
  ADD COLUMN `mp_user_id` varchar(64) DEFAULT NULL,
  ADD COLUMN `payout_share` decimal(5,2) NOT NULL DEFAULT 80.00;

ALTER TABLE `rms_product` ADD COLUMN `is_premium` tinyint(1) NOT NULL DEFAULT 0 AFTER `status`, ADD COLUMN `owner_id` int(11) DEFAULT NULL AFTER `manufacturer_id`, ADD COLUMN `payout_share` decimal(5,2) NOT NULL DEFAULT 80.00 AFTER `owner_id`;
ALTER TABLE `rms_blog_post` ADD COLUMN `is_premium` tinyint(1) NOT NULL DEFAULT 0 AFTER `status`, ADD COLUMN `owner_id` int(11) DEFAULT NULL AFTER `is_premium`, ADD COLUMN `payout_share` decimal(5,2) NOT NULL DEFAULT 80.00 AFTER `owner_id`, ADD COLUMN `price` decimal(10,2) NOT NULL DEFAULT 0.00 AFTER `payout_share`;
ALTER TABLE `rms_landpage` ADD COLUMN `is_premium` tinyint(1) NOT NULL DEFAULT 0 AFTER `status`, ADD COLUMN `owner_id` int(11) DEFAULT NULL AFTER `is_premium`, ADD COLUMN `payout_share` decimal(5,2) NOT NULL DEFAULT 80.00 AFTER `owner_id`, ADD COLUMN `price` decimal(10,2) NOT NULL DEFAULT 0.00 AFTER `payout_share`;

