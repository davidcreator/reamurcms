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
    
    public function installLandpageTables() {
        $sql_file = $this->resolveSqlPath();

        if ($sql_file && file_exists($sql_file)) {
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

    private function resolveSqlPath(): string {
        $candidates = [];
        if (defined('DIR_SYSTEM')) {
            $candidates[] = rtrim(DIR_SYSTEM, '/\\') . '/marketplace/reamurcms_landpage_rmsmod/install/sql/landpage_tables.sql';
        }
        if (defined('DIR_EXTENSION')) {
            $candidates[] = rtrim(DIR_EXTENSION, '/\\') . '/../system/marketplace/reamurcms_landpage_rmsmod/install/sql/landpage_tables.sql';
        }
        if (defined('DIR_INSTALL')) {
            $candidates[] = rtrim(DIR_INSTALL, '/\\') . '/sql/landpage_tables.sql';
        }
        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        return '';
    }
}
