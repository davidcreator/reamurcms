<?php
/**
 * MOOC Module Installation Helper
 * @package ReamurCMS
 */

class MoocModuleInstaller {
    private $db;
    private $config;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Install the MOOC module
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
     * Check if MOOC module already exists in extension table
     * @return bool
     */
    private function moduleExists() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE code = 'module_mooc'");
        return $query->num_rows > 0;
    }

    /**
     * Add MOOC module to extension table
     */
    private function addModuleToExtension() {
        $this->db->query("INSERT INTO " . DB_PREFIX . "extension SET type = 'module', code = 'module_mooc'");
    }

    /**
     * Configure module settings with defaults for the learning platform
     */
    private function configureModuleSettings() {
        $defaults = [
            'module_mooc_status' => 1,
            'module_mooc_name' => 'MOOC',
            'module_mooc_limit' => 12,
            'module_mooc_thumb_width' => 800,
            'module_mooc_thumb_height' => 450,
            'module_mooc_show_instructor' => 1,
            'module_mooc_show_duration' => 1,
            'module_mooc_show_level' => 1,
            'module_mooc_allow_self_enroll' => 1,
            'module_mooc_certificate_enabled' => 1
        ];

        foreach ($defaults as $key => $value) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = '" . $key . "'");

            if ($query->num_rows == 0) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                    store_id = 0,
                    `code` = 'module_mooc',
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
     * Uninstall the MOOC module
     * @return bool Success status
     */
    public function uninstall() {
        $this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE code = 'module_mooc'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE code = 'module_mooc'");

        return true;
    }
}
