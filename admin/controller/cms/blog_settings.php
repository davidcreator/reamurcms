<?php
namespace Reamur\Admin\Controller\Cms;

class BlogSettings extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('text_blog_settings'));

        $this->load->model('setting/setting');

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('blog', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/blog_settings', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/blog_settings', 'user_token=' . $data['user_token']);
        $data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $data['user_token']);
        $data['heading_title'] = $this->language->get('text_blog_settings');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['error_warning'] = $this->error['warning'] ?? '';

        $fields = [
            'blog_comment_auto_approve',
            'blog_comment_require_login',
            'blog_comment_spam_words',
            'blog_comment_rate_limit',
            'blog_share_default_image',
            'blog_schema_auto',
            'blog_rss_enabled',
            'blog_cache_ttl'
        ];

        foreach ($fields as $field) {
            $data[$field] = $this->request->post[$field] ?? $this->config->get($field);
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('text_blog_settings'),
                'href' => $this->url->link('cms/blog_settings', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['heading_general'] = $this->language->get('heading_blog_general');
        $data['entry_comment_auto_approve'] = $this->language->get('entry_comment_auto_approve');
        $data['entry_comment_require_login'] = $this->language->get('entry_comment_require_login');
        $data['entry_comment_spam_words'] = $this->language->get('entry_comment_spam_words');
        $data['entry_comment_rate_limit'] = $this->language->get('entry_comment_rate_limit');
        $data['entry_share_default_image'] = $this->language->get('entry_share_default_image');
        $data['entry_schema_auto'] = $this->language->get('entry_schema_auto');
        $data['entry_rss_enabled'] = $this->language->get('entry_rss_enabled');
        $data['entry_cache_ttl'] = $this->language->get('entry_cache_ttl');

        $data['help_comment_rate_limit'] = $this->language->get('help_comment_rate_limit');
        $data['help_spam_words'] = $this->language->get('help_spam_words');
        $data['help_cache_ttl'] = $this->language->get('help_cache_ttl');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_settings', $data));
    }

    private function validate(): bool {
        $canModify = $this->user->hasPermission('modify', 'cms/blog_settings') || $this->user->hasPermission('modify', 'cms/blog_post');
        if (!$canModify) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
