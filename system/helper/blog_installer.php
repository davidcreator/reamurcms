<?php
/**
 * Blog Installation Helper
 * @package ReamurCMS
 */

class BlogInstaller {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function installBlogTables() {
        // Use the dedicated blog tables SQL file
        $sql_file = DIR_INSTALL . 'sql/blog_tables.sql';
        
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            $statements = explode(';', $sql);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $this->db->query($statement);
                }
            }
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
        $result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "blog_post'");
        return $result->num_rows > 0;
    }
}