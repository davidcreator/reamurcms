<?php
namespace Reamur\Install\Controller\Startup;
/**
 * Class Upgrade
 * @package Reamur\Install\Controller\Startup
 */
class Upgrade extends \Reamur\System\Engine\Controller {
    /**
     * Check if system needs upgrade and redirect accordingly
     * 
     * @return void
     */
    public function index(): void {
        try {
            // Default to no upgrade needed
            $upgrade = false;
            
            // Check if config file exists and has content (installed system)
            if (is_file(DIR_REAMUR . 'config.php') && filesize(DIR_REAMUR . 'config.php') > 0) {
                $upgrade = true;
            }

            // Skip upgrade if already in upgrade process or at final installation step
            if (isset($this->request->get['route'])) {
                $route = $this->request->get['route'];

                if (strpos($route, 'upgrade/') === 0 || strpos($route, 'install/step_4') === 0) {
                    $upgrade = false;
                }
            }

            // If no route param (direct /install/) and installed, still redirect to upgrade
            if (!isset($this->request->get['route']) && $upgrade) {
                $this->response->redirect($this->url->link('upgrade/upgrade'));
                return;
            }

            // Redirect to upgrade controller if upgrade is needed
            if ($upgrade) {
                $this->response->redirect($this->url->link('upgrade/upgrade'));
            }
        } catch (\Exception $e) {
            // Log error if logging is enabled
            if ($this->config->get('error_log')) {
                $this->log->write('Upgrade check error: ' . $e->getMessage());
            }
            
            // Display error in development environment
            if ($this->config->get('error_display')) {
                throw $e;
            }
        }
    }
}
