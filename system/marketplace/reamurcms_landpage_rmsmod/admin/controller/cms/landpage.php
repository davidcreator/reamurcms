<?php
namespace Reamur\Admin\Controller\Cms;

class Landpage extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_title'] = $this->language->get('column_title');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date'] = $this->language->get('column_date');
        $data['column_action'] = $this->language->get('column_action');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $raw_pages = $this->model_cms_landpage->getPages(['start' => $start, 'limit' => $limit]);
        $data['pages'] = array_map(function ($page) use ($data) {
            $page['edit'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token'] . '&page_id=' . $page['page_id']);
            return $page;
        }, $raw_pages);
        $data['total'] = $this->model_cms_landpage->getTotalPages();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/landpage.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/landpage', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_html'] = $this->language->get('entry_html');

        $page_id = (int)($this->request->get['page_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            $payload['author_id'] = $this->user->getId() ?? 0;

            if ($page_id) {
                $this->model_cms_landpage->edit($page_id, $payload);
            } else {
                $page_id = $this->model_cms_landpage->add($payload);
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/landpage', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token'] . ($page_id ? '&page_id=' . $page_id : ''));
        $data['cancel'] = $this->url->link('cms/landpage', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;

        if ($page_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['page'] = $this->model_cms_landpage->getPage($page_id);
        } else {
            $data['page'] = $this->request->post ?? [
                'title' => '',
                'slug' => '',
                'status' => 'draft',
                'template' => 'default',
                'html' => '',
                'published_at' => ''
            ];
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/landpage', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/landpage');
        $this->load->model('cms/landpage');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_landpage->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/landpage', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/landpage')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['title'])) {
            $this->error['title'] = $this->language->get('error_title');
        }
        if (empty($this->request->post['slug'])) {
            $this->request->post['slug'] = $this->slugify($this->request->post['title'] ?? '');
        }
        return !$this->error;
    }

    private function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        return trim($text, '-');
    }
}
