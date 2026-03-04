<?php
namespace Reamur\Admin\Controller\Cms;

class BlogTag extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('text_blog_tags'));

        $this->load->model('cms/blog_tag');
        $this->model_cms_blog_tag->ensureTables();

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;
        $status = $this->request->get['status'] ?? '';
        $q = $this->request->get['q'] ?? '';

        $filter = ['start' => $start, 'limit' => $limit, 'status' => $status, 'q' => $q];
        $tags = $this->model_cms_blog_tag->getTags($filter);
        $total = $this->model_cms_blog_tag->getTotal($filter);

        $data['tags'] = array_map(function ($t) {
            $t['edit'] = $this->url->link('cms/blog_tag.form', 'user_token=' . $this->session->data['user_token'] . '&tag_id=' . $t['tag_id']);
            return $t;
        }, $tags);

        $data['filter_status'] = $status;
        $data['filter_q'] = $q;
        $data['heading_title'] = $this->language->get('text_blog_tags');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all'] = $this->language->get('text_all');

        $data['add'] = $this->url->link('cms/blog_tag.form', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('cms/blog_tag.delete', 'user_token=' . $this->session->data['user_token']);
        $data['user_token'] = $this->session->data['user_token'];
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('text_blog_tags'),
                'href' => $this->url->link('cms/blog_tag', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_tag_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('text_blog_tags'));

        $this->load->model('cms/blog_tag');
        $this->model_cms_blog_tag->ensureTables();

        $tag_id = (int)($this->request->get['tag_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            $payload['slug'] = $payload['slug'] ?: $this->slugify($payload['name'] ?? '');

            if ($tag_id) {
                $this->model_cms_blog_tag->edit($tag_id, $payload);
            } else {
                $tag_id = $this->model_cms_blog_tag->add($payload);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/blog_tag', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/blog_tag.form', 'user_token=' . $data['user_token'] . ($tag_id ? '&tag_id=' . $tag_id : ''));
        $data['cancel'] = $this->url->link('cms/blog_tag', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error ?? [];
        $data['heading_title'] = $this->language->get('text_blog_tags');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        if ($tag_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['tag'] = $this->model_cms_blog_tag->getTag($tag_id);
        } else {
            $data['tag'] = $this->request->post ?? [
                'name' => '',
                'slug' => '',
                'status' => 1,
                'sort_order' => 0
            ];
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('text_blog_tags'),
                'href' => $this->url->link('cms/blog_tag', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_tag_form', $data));
    }

    public function delete(): void {
        $this->load->model('cms/blog_tag');
        $ids = $this->request->post['selected'] ?? [];
        $this->model_cms_blog_tag->delete($ids);
        $this->response->redirect($this->url->link('cms/blog_tag', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/blog_tag')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['name'])) {
            $this->error['name'] = $this->language->get('error_title');
        }
        return !$this->error;
    }

    private function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        return trim($text, '-');
    }
}
