<?php
namespace Reamur\Install\Controller\Startup;
/**
 * Class Install
 * @package Reamur\Install\Controller\Startup
 */
class Install extends \Reamur\System\Engine\Controller {
    /**
     * Initialize installation components
     * 
     * @return void
     * @throws \Exception
     */
    public function index(): void {
        try {
            // Document
            $this->registry->set('document', new \Reamur\System\Library\Document(HTTP_SERVER));

            // URL
            $this->registry->set('url', new \Reamur\System\Library\Url(HTTP_SERVER));

            // Language handling
            $this->handleLanguage();
        } catch (\Exception $e) {
            if ($this->config->get('error_log')) {
                $this->log->write('Install initialization error: ' . $e->getMessage());
            }
            
            if ($this->config->get('error_display')) {
                throw $e;
            }
        }
    }
    
    /**
     * Handle language selection and initialization
     * 
     * @return void
     */
    protected function handleLanguage(): void {
        $language_code = $this->config->get('language_code');
        
        // Check if language change is requested
        if (isset($this->request->get['language'])) {
            // Sanitize language code
            $requested_language = preg_replace('/[^a-zA-Z0-9_-]/', '', $this->request->get['language']);
            
            if ($requested_language && $requested_language != $language_code) {
                // Get available languages
                $language_data = $this->getAvailableLanguages();
                
                // Set language if it's available
                if (in_array($requested_language, $language_data)) {
                    $this->config->set('language_code', $requested_language);
                    $language_code = $requested_language;
                    
                    // Store in session if available
                    if (isset($this->session) && $this->session->getId()) {
                        $this->session->data['language'] = $requested_language;
                    }
                }
            }
        }
        
        // Initialize language object
        $language = new \Reamur\System\Library\Language($language_code);
        $language->addPath(DIR_LANGUAGE);
        
        // Load language files
        $language->load($language_code);
        
        // Register language object
        $this->registry->set('language', $language);
    }
    
    /**
     * Get list of available language codes
     * 
     * @return array
     */
    protected function getAvailableLanguages(): array {
        $language_data = [];
        
        // Get language directories
        $languages = glob(DIR_LANGUAGE . '*', GLOB_ONLYDIR);
        
        if ($languages) {
            foreach ($languages as $language) {
                $language_data[] = basename($language);
            }
        }
        
        return $language_data;
    }
}