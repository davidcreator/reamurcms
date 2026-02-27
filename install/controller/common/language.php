<?php
namespace Reamur\Install\Controller\Common;

/**
 * Class Language
 * @package Reamur\Install\Controller\Common
 */
class Language extends \Reamur\System\Engine\Controller {
    /** @return string */
    public function index(): string {
        $this->load->language('common/language');

        $data['text_language'] = $this->language->get('text_language');

        // Add error handling for missing route
        $route = $this->request->get['route'] ?? $this->config->get('action_default');
        
        // Add validation for language code
        $data['code'] = $this->validateLanguageCode(
            $this->request->get['language'] ?? $this->config->get('language_code')
        );

        // Add directory existence check
        $languagePath = DIR_LANGUAGE;
        if (!is_dir($languagePath)) {
            throw new \Exception('Language directory not found');
        }

        $languages = array_filter(glob($languagePath . '*', GLOB_ONLYDIR));

        $data['languages'] = array_map(function ($code) use ($route) {
            $code = basename($code);
            $language = new \Reamur\System\Library\Language($code);
            $language->addPath(DIR_LANGUAGE);
            $language->load($code);

            return [
                'text' => $language->get('text_name'),
                'code' => $code,
                'href' => $this->url->link($route, 'language=' . $code)
            ];
        }, $languages);

        return $this->load->view('common/language', $data);
    }

    /**
     * Validates the language code
     * @param string $code
     * @return string
     */
    private function validateLanguageCode(string $code): string {
        $code = preg_replace('/[^a-zA-Z0-9_-]/', '', $code);
        return strlen($code) > 0 ? $code : 'en-gb';
    }
}