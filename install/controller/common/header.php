<?php
namespace Reamur\Install\Controller\Common;

/** 
 * Class Header
 * @package Reamur\Install\Controller\Common
 */
class Header extends \Reamur\System\Engine\Controller {
    /** 
     * Generate header data for template
     * 
     * @return string Rendered header template
     * @throws \Exception If template cannot be loaded
     */
    public function index(): string {
        try {
            // Load language file
            $this->load->language('common/header');

            // Prepare data for template
            $data = [
                'title'       => $this->document->getTitle() ?? '',
                'description' => $this->document->getDescription() ?? '',
                'links'       => $this->document->getLinks() ?? [],
                'styles'      => $this->document->getStyles() ?? [],
                'scripts'     => $this->document->getScripts() ?? [],
                'base'        => HTTP_SERVER,
                'home'        => $this->url->link('install/step_1'),
                'language'    => $this->load->controller('common/language')
            ];

            // Set language attributes for HTML tag
            $data['lang'] = $this->config->get('language_code') ?? 'en-gb';
            
            // Return rendered template
            return $this->load->view('common/header', $data);
        } catch (\Exception $e) {
            if ($this->config->get('error_log')) {
                $this->log->write('Header controller error: ' . $e->getMessage());
            }
            
            if ($this->config->get('error_display')) {
                throw $e;
            }
            
            return '';
        }
    }
}