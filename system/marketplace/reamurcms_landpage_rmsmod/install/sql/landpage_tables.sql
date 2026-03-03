-- -----------------------------------------------------------
-- ReamurCMS Landing Page Schema
-- Creates core tables for landing pages, variants, blocks,
-- revisions, analytics and form submissions.
-- Prefix will be replaced by DB_PREFIX at runtime.
-- -----------------------------------------------------------

SET sql_mode = '';
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `rms_landpage_analytics`;
DROP TABLE IF EXISTS `rms_landpage_form_submission`;
DROP TABLE IF EXISTS `rms_landpage_page_revision`;
DROP TABLE IF EXISTS `rms_landpage_page_variant`;
DROP TABLE IF EXISTS `rms_landpage_page_block`;
DROP TABLE IF EXISTS `rms_landpage_page`;

-- Master page record
CREATE TABLE `rms_landpage_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `template` varchar(64) DEFAULT 'default',
  `author_id` int(11) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Content blocks (serialized JSON for flexibility)
CREATE TABLE `rms_landpage_page_block` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `settings` longtext DEFAULT NULL,
  `sort_order` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`block_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `rms_landpage_block_page_fk` FOREIGN KEY (`page_id`) REFERENCES `rms_landpage_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Variants for A/B testing
CREATE TABLE `rms_landpage_page_variant` (
  `variant_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `weight` int(3) NOT NULL DEFAULT 100,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`variant_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `rms_landpage_variant_page_fk` FOREIGN KEY (`page_id`) REFERENCES `rms_landpage_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Revisions (HTML snapshot)
CREATE TABLE `rms_landpage_page_revision` (
  `revision_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `html` longtext NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`revision_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `rms_landpage_revision_page_fk` FOREIGN KEY (`page_id`) REFERENCES `rms_landpage_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Form submissions
CREATE TABLE `rms_landpage_form_submission` (
  `submission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `payload` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`submission_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `rms_landpage_form_page_fk` FOREIGN KEY (`page_id`) REFERENCES `rms_landpage_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Basic analytics
CREATE TABLE `rms_landpage_analytics` (
  `analytics_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `unique_views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `conversions` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `bounces` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `last_viewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`analytics_id`),
  UNIQUE KEY `page_id` (`page_id`),
  CONSTRAINT `rms_landpage_analytics_page_fk` FOREIGN KEY (`page_id`) REFERENCES `rms_landpage_page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
