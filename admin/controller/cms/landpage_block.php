<?php
namespace Reamur\Admin\Controller\Cms;

class LandpageBlock extends \Reamur\System\Engine\Controller {
    private array $error = [];
    public function index(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_blocks'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $data['user_token'] = $this->session->data['user_token'];
        $blocks = $this->model_cms_landpage->getBlocks(['start' => 0, 'limit' => 200]);
        $data['blocks'] = array_map(function ($b) use ($data) {
            $b['edit'] = $this->url->link('cms/landpage_block.form', 'user_token=' . $data['user_token'] . '&block_id=' . $b['block_id']);
            return $b;
        }, $blocks);
        $data['heading_title'] = $this->language->get('heading_blocks');
        $data['column_page'] = $this->language->get('column_page');
        $data['column_type'] = $this->language->get('column_type');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['add'] = $this->url->link('cms/landpage_block.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/landpage_block.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage_block', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_block', $data));
    }

    public function form(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_blocks'));
        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $block_id = (int)($this->request->get['block_id'] ?? 0);
        $block = $block_id ? $this->model_cms_landpage->getBlock($block_id) : [];

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $post = $this->request->post;
            if ($block_id) {
                $this->model_cms_landpage->editBlock($block_id, $post);
            } else {
                $block_id = $this->model_cms_landpage->addBlock($post);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/landpage_block', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/landpage_block.form', 'user_token=' . $data['user_token'] . ($block_id ? '&block_id=' . $block_id : ''));
        $data['cancel'] = $this->url->link('cms/landpage_block', 'user_token=' . $data['user_token']);
        $data['heading_title'] = $this->language->get('heading_blocks');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_html'] = $this->language->get('entry_html');
        $data['entry_template'] = $this->language->get('entry_template');
        $data['entry_featured_image'] = $this->language->get('entry_featured_image');
        $data['entry_custom_css'] = $this->language->get('entry_custom_css');
        $data['text_form'] = $this->language->get('text_form');

        $data['error_warning'] = $this->error['warning'] ?? '';

        $data['block'] = [
            'block_id' => $block_id,
            'page_id' => $this->request->post['page_id'] ?? $block['page_id'] ?? 0,
            'type' => $this->request->post['type'] ?? $block['type'] ?? 'html',
            'settings' => $this->request->post['settings'] ?? $block['settings'] ?? '',
            'sort_order' => $this->request->post['sort_order'] ?? $block['sort_order'] ?? 0
        ];

        $data['pages'] = $this->model_cms_landpage->getPages(['limit' => 200]);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage_block', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('cms/landpage_block_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/landpage');
        $this->load->model('cms/landpage');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $block_id) {
                $this->model_cms_landpage->deleteBlock((int)$block_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
        }
        $this->response->redirect($this->url->link('cms/landpage_block', 'user_token=' . $this->session->data['user_token']));
    }

    private function validate(): bool {
        $hasPermission = $this->user->hasPermission('modify', 'cms/landpage_block') || $this->user->hasPermission('modify', 'cms/landpage');
        if (!$hasPermission) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
