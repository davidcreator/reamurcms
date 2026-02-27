<?php
/**
 * Blog Module Installation Helper
 * @package ReamurCMS
 */

class BlogModuleInstaller {
    private $db;
    private $config;
    
    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }
    
    /**
     * Install the blog module
     * @return bool Success status
     */
    public function install() {
        // Step 1: Check if module already exists
        if ($this->moduleExists()) {
            return false; // Module already installed
        }
        
        // Step 2: Add module to extension table
        $this->addModuleToExtension();
        
        // Step 3: Configure module settings
        $this->configureModuleSettings();
        
        return true;
    }
    
    /**
     * Check if blog module already exists in extension table
     * @return bool
     */
    private function moduleExists() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE code = 'module_blog'");
        return $query->num_rows > 0;
    }
    
    /**
     * Add blog module to extension table
     */
    private function addModuleToExtension() {
        $this->db->query("INSERT INTO " . DB_PREFIX . "extension SET type = 'module', code = 'module_blog'");
    }
    
    /**
     * Configure module settings
     */
    private function configureModuleSettings() {
        $settings = [
            'module_blog_status' => 1,
            'module_blog_name' => 'Blog',
            'module_blog_limit' => 10,
            'module_blog_width' => 800,
            'module_blog_height' => 500,
            'module_blog_show_title' => 1,
            'module_blog_show_excerpt' => 1,
            'module_blog_show_image' => 1,
            'module_blog_show_date' => 1,
            'module_blog_show_author' => 1
        ];
        
        foreach ($settings as $key => $value) {
            // Check if setting already exists
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = '" . $key . "'");
            
            if ($query->num_rows == 0) {
                // Add new setting
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
                    store_id = 0, 
                    `code` = 'module_blog', 
                    `key` = '" . $key . "', 
                    `value` = '" . $value . "'");
            } else {
                // Update existing setting
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET 
                    `value` = '" . $value . "' 
                    WHERE `key` = '" . $key . "'");
            }
        }
    }
    
    /**
     * Uninstall the blog module
     * @return bool Success status
     */
    public function uninstall() {
        // Remove from extension table
        $this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE code = 'module_blog'");
        
        // Remove settings
        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE code = 'module_blog'");
        
        return true;
    }
}