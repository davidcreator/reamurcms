-- -----------------------------------------------------------
-- ReamurCMS Blog Extension Schema
-- This file creates all blog-related tables and seeds defaults
-- Prefix follows the base dump (`rms_`). Adjust if you use another DB_PREFIX.
-- -----------------------------------------------------------

SET sql_mode = '';
SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables (child tables first)
DROP TABLE IF EXISTS `rms_blog_analytics`;
DROP TABLE IF EXISTS `rms_blog_comment`;
DROP TABLE IF EXISTS `rms_blog_post_to_category`;
DROP TABLE IF EXISTS `rms_blog_post`;
DROP TABLE IF EXISTS `rms_blog_category`;
DROP TABLE IF EXISTS `rms_blog_post_template`;

-- -----------------------------------------------------------
-- Table: rms_blog_post_template
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_post_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `template_content` longtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed default templates (same as base dump)
INSERT INTO `rms_blog_post_template` (`template_id`, `name`, `description`, `template_content`, `status`, `date_added`, `date_modified`) VALUES
(1, 'Standard Article', 'Basic blog post template with introduction, body, and conclusion sections', '<h2>Introduction</h2>\n<p>Write your introduction here. Provide context and background information about the topic. Explain why this topic is important or relevant to your readers.</p>\n\n<h2>Main Content</h2>\n<p>Develop your main points here. Use paragraphs to separate different ideas or aspects of your topic. Include relevant examples, data, or quotes to support your arguments.</p>\n\n<h3>Subheading 1</h3>\n<p>Expand on your first main point here.</p>\n\n<h3>Subheading 2</h3>\n<p>Expand on your second main point here.</p>\n\n<h2>Conclusion</h2>\n<p>Summarize the key points discussed in your article. Provide a final thought or call to action for your readers.</p>', 1, NOW(), NOW()),
(2, 'Tutorial', 'Step-by-step guide template for how-to articles and tutorials', '<h2>Introduction</h2>\n<p>Briefly explain what this tutorial will teach and why it\\'s useful. Mention any prerequisites or materials needed.</p>\n\n<h2>What You\\'ll Need</h2>\n<ul>\n  <li>Item 1</li>\n  <li>Item 2</li>\n  <li>Item 3</li>\n</ul>\n\n<h2>Step 1: Getting Started</h2>\n<p>Detailed instructions for the first step. Include screenshots or images if helpful.</p>\n\n<h2>Step 2: Next Phase</h2>\n<p>Detailed instructions for the second step.</p>\n\n<h2>Step 3: Continuing the Process</h2>\n<p>Detailed instructions for the third step.</p>\n\n<h2>Step 4: Finishing Up</h2>\n<p>Detailed instructions for the final step.</p>\n\n<h2>Troubleshooting</h2>\n<p>Address common issues or questions that might arise during the tutorial.</p>\n\n<h2>Conclusion</h2>\n<p>Summarize what the reader has learned and suggest next steps or related tutorials.</p>', 1, NOW(), NOW()),
(3, 'News Article', 'Template for news updates and announcements', '<h2>Headline</h2>\n<p><strong>Date:</strong> [Insert date]</p>\n\n<h3>Summary</h3>\n<p>A brief one or two-sentence summary of the news item.</p>\n\n<h3>Key Details</h3>\n<p>Provide the main facts and information about the news item. Answer the who, what, when, where, why, and how questions.</p>\n\n<h3>Background</h3>\n<p>Offer relevant context or history related to this news.</p>\n\n<h3>Quotes</h3>\n<blockquote>\n  <p>\"Insert a relevant quote from a key person involved in the news.\"</p>\n  <footer>— Quote Attribution</footer>\n</blockquote>\n\n<h3>Impact</h3>\n<p>Explain the significance or implications of this news for your readers or industry.</p>\n\n<h3>Next Steps</h3>\n<p>If applicable, mention what will happen next or what actions readers might take in response to this news.</p>\n\n<h3>Additional Resources</h3>\n<ul>\n  <li><a href=\"#\">Related link 1</a></li>\n  <li><a href=\"#\">Related link 2</a></li>\n</ul>', 1, NOW(), NOW()),
(4, 'Product Review', 'Template for product or service reviews', '<h2>Product Review: [Product Name]</h2>\n\n<h3>Overview</h3>\n<p>Brief introduction to the product and why you\\'re reviewing it.</p>\n\n<h3>Specifications</h3>\n<ul>\n  <li>Spec 1: Detail</li>\n  <li>Spec 2: Detail</li>\n  <li>Spec 3: Detail</li>\n  <li>Price: $XX.XX</li>\n</ul>\n\n<h3>Pros</h3>\n<ul>\n  <li>Advantage 1</li>\n  <li>Advantage 2</li>\n  <li>Advantage 3</li>\n</ul>\n\n<h3>Cons</h3>\n<ul>\n  <li>Disadvantage 1</li>\n  <li>Disadvantage 2</li>\n  <li>Disadvantage 3</li>\n</ul>\n\n<h3>Performance</h3>\n<p>Detailed analysis of how the product performs in real-world usage.</p>\n\n<h3>Comparison</h3>\n<p>How this product compares to similar products or previous versions.</p>\n\n<h3>Rating</h3>\n<p>Overall rating: X/5 stars</p>\n\n<h3>Verdict</h3>\n<p>Final thoughts and recommendations about whether the product is worth purchasing and who would benefit most from it.</p>', 1, NOW(), NOW());

-- -----------------------------------------------------------
-- Table: rms_blog_category
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_blog_post
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('draft','published','pending','private','archived') NOT NULL DEFAULT 'draft',
  `featured_image` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `rms_blog_post_author_fk` FOREIGN KEY (`author_id`) REFERENCES `rms_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_blog_post_to_category (many-to-many)
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_post_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`, `category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `rms_blog_ptc_post_fk` FOREIGN KEY (`post_id`) REFERENCES `rms_blog_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_blog_ptc_cat_fk` FOREIGN KEY (`category_id`) REFERENCES `rms_blog_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_blog_comment
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `author` varchar(64) NOT NULL,
  `email` varchar(96) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `blog_post_id` (`blog_post_id`),
  KEY `customer_id` (`customer_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `rms_blog_comment_post_fk` FOREIGN KEY (`blog_post_id`) REFERENCES `rms_blog_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rms_blog_comment_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `rms_customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `rms_blog_comment_parent_fk` FOREIGN KEY (`parent_id`) REFERENCES `rms_blog_comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------------
-- Table: rms_blog_analytics
-- Purpose: aggregate engagement metrics per post
-- -----------------------------------------------------------
CREATE TABLE `rms_blog_analytics` (
  `analytics_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) NOT NULL,
  `views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `unique_views` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `likes` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `shares` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `last_viewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`analytics_id`),
  UNIQUE KEY `blog_post_id` (`blog_post_id`),
  CONSTRAINT `rms_blog_analytics_post_fk` FOREIGN KEY (`blog_post_id`) REFERENCES `rms_blog_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
