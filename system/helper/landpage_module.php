<?php
/**
 * Landpage Module Installation Helper
 * @package ReamurCMS
 */

class LandpageModuleInstaller {
    private $db;
    private $config;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Install the landpage module
     * @return bool Success status
     */
    public function install() {
        if ($this->moduleExists()) {
            return false;
        }

        $this->addModuleToExtension();
        $this->configureModuleSettings();

        return true;
    }

    /**
     * Check if landpage module already exists in extension table
     * @return bool
     */
    private function moduleExists() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE code = 'module_landpage'");
        return $query->num_rows > 0;
    }

    /**
     * Add landpage module to extension table
     */
    private function addModuleToExtension() {
        $this->db->query("INSERT INTO " . DB_PREFIX . "extension SET type = 'module', code = 'module_landpage'");
    }

    /**
     * Configure module settings with sensible defaults
     */
    private function configureModuleSettings() {
        $defaults = [
            'module_landpage_status' => 1,
            'module_landpage_name' => 'Landing Pages',
            'module_landpage_default_template' => 'default',
            'module_landpage_cache_ttl' => 300,
            'module_landpage_allow_custom_css' => 1,
            'module_landpage_auto_publish' => 0,
            'module_landpage_revision_limit' => 10
        ];

        foreach ($defaults as $key => $value) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = '" . $key . "'");

            if ($query->num_rows == 0) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                    store_id = 0,
                    `code` = 'module_landpage',
                    `key` = '" . $key . "',
                    `value` = '" . $value . "'");
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET 
                    `value` = '" . $value . "'
                    WHERE `key` = '" . $key . "'");
            }
        }
    }

    /**
     * Uninstall the landpage module
     * @return bool Success status
     */
    public function uninstall() {
        $this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE code = 'module_landpage'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE code = 'module_landpage'");

        return true;
    }
}
