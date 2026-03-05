<?php
/**
 * MOOC Installation Helper
 * @package ReamurCMS
 */

class MoocInstaller {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Install MOOC tables using the bundled SQL file.
     *
     * Expected file: DIR_INSTALL . 'sql/mooc_tables.sql'
     *
     * @return bool True when executed, false if file not found
     */
    public function installMoocTables() {
        $sql_file = $this->resolveSqlPath();

        if (!$sql_file || !file_exists($sql_file)) {
            return false;
        }

        $sql = file_get_contents($sql_file);
        $sql = str_replace('rms_', DB_PREFIX, $sql);
        $statements = explode(';', $sql);

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                $this->db->query($statement);
            }
        }
        return true;
    }
    
    /**
     * Drop MOOC tables.
     *
     * Adjust the list as the schema evolves.
     */
    public function uninstallMoocTables() {
        $tables = [
            'mooc_payment',
            'mooc_badge_unlock',
            'mooc_badge',
            'mooc_goal',
            'mooc_points',
            'mooc_streak',
            'mooc_enrollment',
            'mooc_progress',
            'mooc_certificate',
            'mooc_notification',
            'mooc_quiz_answer',
            'mooc_quiz_question',
            'mooc_quiz',
            'mooc_lesson_content',
            'mooc_lesson',
            'mooc_course_category',
            'mooc_category',
            'mooc_course_instructor',
            'mooc_instructor',
            'mooc_course'
        ];
        
        foreach ($tables as $table) {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . $table . "`");
        }
    }
    
    /**
     * Quick existence check to avoid double installation.
     *
     * @return bool
     */
    public function moocTablesExist() {
        $result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "mooc_course'");
        return $result->num_rows > 0;
    }

    private function resolveSqlPath(): string {
        $candidates = [];

        if (defined('DIR_SYSTEM')) {
            $candidates[] = rtrim(DIR_SYSTEM, '/\\') . '/marketplace/reamurcms_mooc_rmsmod/install/sql/mooc_tables.sql';
        }
        if (defined('DIR_EXTENSION')) {
            $candidates[] = rtrim(DIR_EXTENSION, '/\\') . '/../system/marketplace/reamurcms_mooc_rmsmod/install/sql/mooc_tables.sql';
        }
        if (defined('DIR_INSTALL')) {
            $candidates[] = rtrim(DIR_INSTALL, '/\\') . '/sql/mooc_tables.sql';
        }

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return '';
    }
}
