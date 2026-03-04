<?php
namespace Reamur\Admin\Controller\Cms;

class LandpageTemplate extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_template'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $data['user_token'] = $this->session->data['user_token'];
        $templates = $this->model_cms_landpage->getTemplates(['start' => $start, 'limit' => $limit]);
        $data['templates'] = array_map(function ($t) use ($data) {
            $t['edit'] = $this->url->link('cms/landpage_template.form', 'user_token=' . $data['user_token'] . '&template_id=' . $t['template_id']);
            return $t;
        }, $templates);
        $data['total'] = $this->model_cms_landpage->getTotalTemplates();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['add'] = $this->url->link('cms/landpage_template.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/landpage_template.delete', 'user_token=' . $data['user_token']);

        $data['heading_title'] = $this->language->get('heading_template');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_add'] = $this->language->get('text_add');
        $data['column_template'] = $this->language->get('column_template');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date'] = $this->language->get('column_date');
        $data['column_action'] = $this->language->get('column_action');

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage_template', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_template', $data));
    }

    public function form(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_template'));
        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $template_id = (int)($this->request->get['template_id'] ?? 0);
        $template = $template_id ? $this->model_cms_landpage->getTemplate($template_id) : [];

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $post = $this->request->post;
            if ($template_id) {
                $this->model_cms_landpage->editTemplate($template_id, $post);
            } else {
                $template_id = $this->model_cms_landpage->addTemplate($post);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/landpage_template', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/landpage_template.form', 'user_token=' . $data['user_token'] . ($template_id ? '&template_id=' . $template_id : ''));
        $data['cancel'] = $this->url->link('cms/landpage_template', 'user_token=' . $data['user_token']);

        $data['template'] = [
            'template_id' => $template_id,
            'name' => $this->request->post['name'] ?? $template['name'] ?? '',
            'code' => $this->request->post['code'] ?? $template['code'] ?? '',
            'description' => $this->request->post['description'] ?? $template['description'] ?? '',
            'html' => $this->request->post['html'] ?? $template['html'] ?? '',
            'css' => $this->request->post['css'] ?? $template['css'] ?? '',
            'status' => $this->request->post['status'] ?? $template['status'] ?? 1
        ];

        $data['heading_title'] = $this->language->get('heading_template');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_html'] = $this->language->get('entry_html');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['error_warning'] = $this->error['warning'] ?? '';

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage_template', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('cms/landpage_template_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/landpage');
        $this->load->model('cms/landpage');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $template_id) {
                $this->model_cms_landpage->deleteTemplate((int)$template_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
        }
        $this->response->redirect($this->url->link('cms/landpage_template', 'user_token=' . $this->session->data['user_token']));
    }

    private function validate(): bool {
        $hasPermission = $this->user->hasPermission('modify', 'cms/landpage_template') || $this->user->hasPermission('modify', 'cms/landpage');
        if (!$hasPermission) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['name'] ?? '') || empty($this->request->post['code'] ?? '')) {
            $this->error['warning'] = $this->language->get('error_title');
        }
        return !$this->error;
    }
}
