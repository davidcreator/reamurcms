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
        $data['column_premium'] = $this->language->get('column_premium');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_owner'] = $this->language->get('column_owner');
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
        $this->load->model('cms/mooc_instructor');
        $owner_map = [];
        foreach ($this->model_cms_mooc_instructor->getApprovedInstructors(['start' => 0, 'limit' => 1000]) as $instr) {
            $owner_map[$instr['instructor_id']] = $instr['name'];
        }
        $data['posts'] = array_map(function ($post) use ($data, $owner_map) {
            $post['edit'] = $this->url->link('cms/blog_post.form', 'user_token=' . $data['user_token'] . '&post_id=' . $post['post_id']);
            $post['owner_name'] = $owner_map[$post['owner_id'] ?? 0] ?? $this->language->get('text_owner_platform');
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

        $this->load->model('cms/mooc_instructor');
        $data['instructors'] = $this->model_cms_mooc_instructor->getApprovedInstructors(['start' => 0, 'limit' => 1000]);

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
        $this->load->model('tool/image');

        $this->document->addScript('view/js/ckeditor/ckeditor.js');
        $this->document->addScript('view/js/ckeditor/adapters/jquery.js');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_clear'] = $this->language->get('button_clear');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['text_owner_platform'] = $this->language->get('text_owner_platform');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_is_premium'] = $this->language->get('entry_is_premium');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_owner'] = $this->language->get('entry_owner');
        $data['entry_payout_share'] = $this->language->get('entry_payout_share');
        $data['entry_excerpt'] = $this->language->get('entry_excerpt');
        $data['entry_content'] = $this->language->get('entry_content');
        $data['entry_featured_image'] = $this->language->get('entry_featured_image');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_published_at'] = $this->language->get('entry_published_at');
        $data['ckeditor'] = $this->config->get('config_language');

        $post_id = (int)($this->request->get['post_id'] ?? 0);
        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            $payload['author_id'] = $this->user->getId() ?? 0;
            if (!empty($payload['published_at'])) {
                $payload['published_at'] = str_replace('T', ' ', $payload['published_at']);
            }

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
                'is_premium' => 0,
                'price' => 0,
                'owner_id' => 0,
                'payout_share' => 80,
                'excerpt' => '',
                'content' => '',
                'featured_image' => '',
                'published_at' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keyword' => ''
            ];
        }

        if (!empty($data['post']['published_at'])) {
            $data['post']['published_at'] = date('Y-m-d\\TH:i', strtotime($data['post']['published_at']));
        }

        $image = $data['post']['featured_image'] ?? '';
        if ($image && is_file(DIR_IMAGE . $image)) {
            $data['thumb'] = $this->model_tool_image->resize($image, 200, 200);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 200, 200);
            $data['post']['featured_image'] = '';
        }
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 200, 200);

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
}
