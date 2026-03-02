<?php
namespace Reamur\Admin\Controller\Common;
/**
 * Class Language
 *
 * @package Reamur\Admin\Controller\Common
 */
class Language extends \Reamur\System\Engine\Controller {
    /**
     * Language selector page
     * @return string
     */
    public function index(): string {
        $data = [];
        $data['languages'] = [];

        $this->load->model('localisation/language');
        $results = $this->model_localisation_language->getLanguages();

        foreach ($results as $result) {
            $data['languages'][] = [
                'name'  => $result['name'],
                'code'  => $result['code'],
                'image' => $result['image']
            ];
        }

        $data['code'] = $this->request->cookie['language'] ?? $this->config->get('config_language');

        // Redirect
        $url_data = $this->request->get;
        $route = $url_data['route'] ?? 'common/dashboard';
        unset($url_data['route']);
        $url = $url_data ? '&' . urldecode(http_build_query($url_data)) : '';
        $data['redirect'] = $this->url->link($route, $url);
        $data['user_token'] = $this->session->data['user_token'];

        return $this->load->view('common/language', $data);
    }

    /**
     * Save language selection
     * @return void
     */
    public function save(): void {
        $this->load->language('common/language');
        $json = [];
        $code = $this->request->post['code'] ?? '';
        $redirect = isset($this->request->post['redirect']) ? htmlspecialchars_decode($this->request->post['redirect'], ENT_COMPAT) : '';
        $this->load->model('localisation/language');
        $language_info = $this->model_localisation_language->getLanguageByCode($code);

        if (!$language_info) {
            $json['error'] = $this->language->get('error_language');
        }
        if (!$json) {
            $option = [
                'expires'  => time() + 60 * 60 * 24 * 365 * 10,
                'path'     => $this->config->get('session_path'),
                'SameSite' => $this->config->get('config_session_samesite')
            ];
            
            setcookie('language', $code, $option);
            
            $base_url = $this->config->get('config_url');
            if ($redirect && strpos($redirect, $base_url) === 0) {
                $json['redirect'] = $redirect;
            } else {
                $json['redirect'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
