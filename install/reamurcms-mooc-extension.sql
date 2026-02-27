-- -----------------------------------------------------------
-- ReamurCMS MOOC Extension Schema
-- Creates all MOOC-related tables for courses, lessons, quizzes,
-- enrollment, progress tracking, and certification.
-- Uses prefix `rms_` to match the base dump. Adjust if needed.
-- -----------------------------------------------------------

SET sql_mode = '';
SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables (children first)
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

-- -----------------------------------------------------------
-- Table: rms_mooc_instructor
-- -----------------------------------------------------------
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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`instructor_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `rms_mooc_instructor_user_fk` FOREIGN KEY (`user_id`) REFERENCES `rms_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_category
-- -----------------------------------------------------------
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

-- -----------------------------------------------------------
-- Table: rms_mooc_course
-- -----------------------------------------------------------
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

-- -----------------------------------------------------------
-- Table: rms_mooc_course_instructor (many-to-many)
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_course_instructor` (
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`, `instructor_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `rms_mooc_ci_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_ci_instructor_fk` FOREIGN KEY (`instructor_id`) REFERENCES `rms_mooc_instructor` (`instructor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_course_category (many-to-many)
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_course_category` (
  `course_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`, `category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `rms_mooc_cc_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_cc_category_fk` FOREIGN KEY (`category_id`) REFERENCES `rms_mooc_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_lesson
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_lesson` (
  `lesson_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content_type` enum('video','article','quiz','live') NOT NULL DEFAULT 'article',
  `video_url` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(5) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `release_at` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`lesson_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `rms_mooc_lesson_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_lesson_content
-- -----------------------------------------------------------
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

-- -----------------------------------------------------------
-- Table: rms_mooc_quiz
-- -----------------------------------------------------------
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

-- -----------------------------------------------------------
-- Table: rms_mooc_quiz_question
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_quiz_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `type` enum('single','multiple','true_false','text') NOT NULL DEFAULT 'single',
  `question` text NOT NULL,
  `options` longtext DEFAULT NULL,
  `correct_answer` longtext DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `sort_order` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`question_id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `rms_mooc_question_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `rms_mooc_quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_quiz_answer
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_quiz_answer` (
  `answer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `selected_answer` longtext DEFAULT NULL,
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

-- -----------------------------------------------------------
-- Table: rms_mooc_enrollment
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_enrollment` (
  `enrollment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('active','completed','cancelled','refunded','pending') NOT NULL DEFAULT 'active',
  `enrolled_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  `progress_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`enrollment_id`),
  UNIQUE KEY `course_customer_unique` (`course_id`,`customer_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `rms_mooc_enroll_course_fk` FOREIGN KEY (`course_id`) REFERENCES `rms_mooc_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_enroll_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_progress
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_progress` (
  `progress_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `enrollment_id` bigint(20) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `status` enum('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  `last_watched_at` datetime DEFAULT NULL,
  `seconds_watched` int(11) NOT NULL DEFAULT 0,
  `score` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`progress_id`),
  UNIQUE KEY `enrollment_lesson_unique` (`enrollment_id`,`lesson_id`),
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `rms_mooc_progress_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `rms_mooc_enrollment` (`enrollment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_mooc_progress_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `rms_mooc_lesson` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_mooc_certificate
-- -----------------------------------------------------------
CREATE TABLE `rms_mooc_certificate` (
  `certificate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `enrollment_id` bigint(20) NOT NULL,
  `certificate_code` varchar(64) NOT NULL,
  `issued_at` datetime NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `verification_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`certificate_id`),
  UNIQUE KEY `enrollment_unique` (`enrollment_id`),
  UNIQUE KEY `certificate_code` (`certificate_code`),
  CONSTRAINT `rms_mooc_certificate_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `rms_mooc_enrollment` (`enrollment_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
