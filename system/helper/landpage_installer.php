<?php
/**
 * Landpage Installation Helper
 * @package ReamurCMS
 */

class LandpageInstaller {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Install landing page tables using an SQL bundle file.
     *
     * Expected file: DIR_INSTALL . 'sql/landpage_tables.sql'
     *
     * @return bool True when executed, false if file not found
     */
    public function installLandpageTables() {
        $sql_file = DIR_INSTALL . 'sql/landpage_tables.sql';
        
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
    
    /**
     * Drop landing page tables.
     *
     * Adjust the list as your schema evolves.
     */
    public function uninstallLandpageTables() {
        $tables = [
            'landpage_analytics',
            'landpage_form_submission',
            'landpage_page_revision',
            'landpage_page_variant',
            'landpage_page_block',
            'landpage_page'
        ];
        
        foreach ($tables as $table) {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . $table . "`");
        }
    }
    
    /**
     * Quick existence check to guard re-installation.
     *
     * @return bool
     */
    public function landpageTablesExist() {
        $result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "landpage_page'");
        return $result->num_rows > 0;
    }
}
