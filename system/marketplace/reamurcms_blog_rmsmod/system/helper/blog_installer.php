<?php
/**
 * Blog Installation Helper
 * @package ReamurCMS
 */

class BlogInstaller {
    private $db;
    private const BLOG_TABLE = 'blog_post';
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function installBlogTables() {
        // Use the dedicated blog tables SQL file
        $sql_file = DIR_INSTALL . 'sql/blog_tables.sql';
        
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            $sql = str_replace('rms_', DB_PREFIX, $sql);
            $statements = explode(';', $sql);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $this->db->query($statement);
                }
            }

            // Ensure latest schema after initial creation
            $this->upgradeBlogTables();
            return true;
        }
        return false;
    }
    
    public function uninstallBlogTables() {
        $tables = ['blog_analytics', 'blog_comment', 'blog_post_to_category', 'blog_category', 'blog_post', 'blog_post_template'];
        
        foreach ($tables as $table) {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . $table . "`");
        }
    }
    
    public function blogTablesExist() {
        $result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . self::BLOG_TABLE . "'");
        return $result->num_rows > 0;
    }

    /**
     * Apply incremental changes when the base table already exists.
     * Keeps blog_post aligned with latest columns/indexes without destructive rebuilds.
     */
    public function upgradeBlogTables(): void {
        if (!$this->blogTablesExist()) {
            return;
        }

        $table = DB_PREFIX . self::BLOG_TABLE;

        $this->addColumnIfMissing($table, 'meta_title', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'meta_description', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'meta_keywords', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'canonical_url', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'og_image', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'tags', "VARCHAR(255) DEFAULT NULL");
        $this->addColumnIfMissing($table, 'schema_json', "LONGTEXT");
        $this->addColumnIfMissing($table, 'reading_time', "INT(11) UNSIGNED NOT NULL DEFAULT 0");
        $this->addColumnIfMissing($table, 'is_featured', "TINYINT(1) NOT NULL DEFAULT 0");

        $this->addIndexIfMissing($table, 'idx_status_published', "(status, published_at)");
        $this->addIndexIfMissing($table, 'idx_is_featured', "(is_featured)");

        $category = DB_PREFIX . 'blog_category';
        $this->addColumnIfMissing($category, 'parent_id', "INT(11) NOT NULL DEFAULT 0");
        $this->addIndexIfMissing($category, 'idx_parent_id', "(parent_id)");

        $tagTable = DB_PREFIX . 'blog_tag';
        // Ensure tag table exists and is up to date
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . $tagTable . "` (
            `tag_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `slug` varchar(160) NOT NULL,
            `status` tinyint(1) NOT NULL DEFAULT 1,
            `sort_order` int(3) NOT NULL DEFAULT 0,
            `date_added` datetime NOT NULL,
            `date_modified` datetime NOT NULL,
            PRIMARY KEY (`tag_id`),
            UNIQUE KEY `slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        $this->addColumnIfMissing($tagTable, 'sort_order', "INT(3) NOT NULL DEFAULT 0");
        $this->addColumnIfMissing($tagTable, 'status', "TINYINT(1) NOT NULL DEFAULT 1");
    }

    private function addColumnIfMissing(string $table, string $column, string $definition): void {
        if (!$this->columnExists($table, $column)) {
            $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $this->db->escape($column) . "` " . $definition);
        }
    }

    private function addIndexIfMissing(string $table, string $indexName, string $definition): void {
        $result = $this->db->query("SHOW INDEX FROM `" . $table . "` WHERE Key_name = '" . $this->db->escape($indexName) . "'");
        if ($result->num_rows === 0) {
            $this->db->query("ALTER TABLE `" . $table . "` ADD INDEX `" . $this->db->escape($indexName) . "` " . $definition);
        }
    }

    private function columnExists(string $table, string $column): bool {
        $result = $this->db->query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $this->db->escape($column) . "'");
        return $result->num_rows > 0;
    }

    private function tableExists(string $table): bool {
        $result = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($table) . "'");
        return $result->num_rows > 0;
    }
}
