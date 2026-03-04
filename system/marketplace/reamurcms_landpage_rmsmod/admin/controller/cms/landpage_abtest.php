<?php
namespace Reamur\Admin\Controller\Cms;

class LandpageABTest extends \Reamur\System\Engine\Controller {
    private array $error = [];
    public function index(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_abtests'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $data['user_token'] = $this->session->data['user_token'];
        $variants = $this->model_cms_landpage->getVariants(['start' => 0, 'limit' => 200]);
        $data['variants'] = array_map(function ($v) use ($data) {
            $v['edit'] = $this->url->link('cms/landpage_a_b_test.form', 'user_token=' . $data['user_token'] . '&variant_id=' . $v['variant_id']);
            return $v;
        }, $variants);
        $data['heading_title'] = $this->language->get('heading_abtests');
        $data['text_add'] = $this->language->get('text_add_variant') ?? $this->language->get('text_add');
        $data['column_page'] = $this->language->get('column_page');
        $data['column_variant'] = $this->language->get('column_variant');
        $data['column_weight'] = $this->language->get('column_weight');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
        $data['text_variant_active'] = $this->language->get('text_variant_active');
        $data['text_variant_disabled'] = $this->language->get('text_variant_disabled');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['add'] = $this->url->link('cms/landpage_a_b_test.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/landpage_a_b_test.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage_a_b_test', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_a_b_test', $data));
    }

    public function form(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_abtests'));
        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $variant_id = (int)($this->request->get['variant_id'] ?? 0);
        $variant = $variant_id ? $this->model_cms_landpage->getVariant($variant_id) : [];

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $post = $this->request->post;
            if ($variant_id) {
                $this->model_cms_landpage->editVariant($variant_id, $post);
            } else {
                $variant_id = $this->model_cms_landpage->addVariant($post);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/landpage_a_b_test', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/landpage_a_b_test.form', 'user_token=' . $data['user_token'] . ($variant_id ? '&variant_id=' . $variant_id : ''));
        $data['cancel'] = $this->url->link('cms/landpage_a_b_test', 'user_token=' . $data['user_token']);
        $data['error_warning'] = $this->error['warning'] ?? '';

        $data['variant'] = [
            'variant_id' => $variant_id,
            'page_id' => $this->request->post['page_id'] ?? $variant['page_id'] ?? 0,
            'name' => $this->request->post['name'] ?? $variant['name'] ?? '',
            'weight' => $this->request->post['weight'] ?? $variant['weight'] ?? 100,
            'status' => $this->request->post['status'] ?? $variant['status'] ?? 1
        ];

        $data['pages'] = $this->model_cms_landpage->getPages(['limit' => 200]);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_abtests'),
                'href' => $this->url->link('cms/landpage_a_b_test', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_a_b_test_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/landpage');
        $this->load->model('cms/landpage');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $variant_id) {
                $this->model_cms_landpage->deleteVariant((int)$variant_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
        }
        $this->response->redirect($this->url->link('cms/landpage_a_b_test', 'user_token=' . $this->session->data['user_token']));
    }

    private function validate(): bool {
        $hasPermission = $this->user->hasPermission('modify', 'cms/landpage_a_b_test') || $this->user->hasPermission('modify', 'cms/landpage');
        if (!$hasPermission) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
