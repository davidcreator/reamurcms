<?php
namespace Reamur\Admin\Controller\Cms;

class BlogPost extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/blog_post');
        $this->model_cms_blog_post->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_title'] = $this->language->get('column_title');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date'] = $this->language->get('column_date');
        $data['column_action'] = $this->language->get('column_action');

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/blog_post.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/blog_post.delete', 'user_token=' . $data['user_token']);

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $raw_posts = $this->model_cms_blog_post->getPosts([
            'start' => $start,
            'limit' => $limit
        ]);
        $data['posts'] = array_map(function ($post) use ($data) {
            $post['edit'] = $this->url->link('cms/blog_post.form', 'user_token=' . $data['user_token'] . '&post_id=' . $post['post_id']);
            return $post;
        }, $raw_posts);
        $data['total'] = $this->model_cms_blog_post->getTotalPosts();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/blog_post', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_post_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/blog_post');
        $this->model_cms_blog_post->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['text_pending'] = $this->language->get('text_pending');
        $data['text_private'] = $this->language->get('text_private');
        $data['text_archived'] = $this->language->get('text_archived');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_excerpt'] = $this->language->get('entry_excerpt');
        $data['entry_content'] = $this->language->get('entry_content');
        $data['entry_featured_image'] = $this->language->get('entry_featured_image');
        $data['entry_og_image'] = $this->language->get('entry_og_image');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
        $data['entry_canonical_url'] = $this->language->get('entry_canonical_url');
        $data['entry_tags'] = $this->language->get('entry_tags');
        $data['entry_published_at'] = $this->language->get('entry_published_at');
        $data['entry_schema_json'] = $this->language->get('entry_schema_json');
        $data['entry_is_featured'] = $this->language->get('entry_is_featured');

        $post_id = (int)($this->request->get['post_id'] ?? 0);
        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            $payload['published_at'] = $this->normalizeDateTime($payload['published_at'] ?? '');
            $payload['author_id'] = $this->user->getId() ?? 0;

            if ($post_id) {
                $this->model_cms_blog_post->edit($post_id, $payload);
            } else {
                $post_id = $this->model_cms_blog_post->add($payload);
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/blog_post', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/blog_post.form', 'user_token=' . $data['user_token'] . ($post_id ? '&post_id=' . $post_id : ''));
        $data['cancel'] = $this->url->link('cms/blog_post', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error ?? [];

        if ($post_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['post'] = $this->model_cms_blog_post->getPost($post_id);
        } else {
            $data['post'] = $this->request->post ?? [
                'title' => '',
                'slug' => '',
                'status' => 'draft',
                'excerpt' => '',
                'content' => '',
                'featured_image' => '',
                'og_image' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'canonical_url' => '',
                'tags' => '',
                'schema_json' => '',
                'reading_time' => 0,
                'is_featured' => 0,
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
                'href' => $this->url->link('cms/blog_post', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_post_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog_post');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_blog_post->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/blog_post', 'user_token=' . $this->session->data['user_token']));
    }

    private array $error = [];

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/blog_post')) {
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

    private function normalizeDateTime(string $value): string {
        $value = trim($value);
        if ($value === '') {
            return '';
        }
        $value = str_replace('T', ' ', $value);
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $value)) {
            $value .= ':00';
        }
        return $value;
    }
}
