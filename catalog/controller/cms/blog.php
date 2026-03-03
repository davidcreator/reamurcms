<?php
namespace Reamur\Catalog\Controller\Cms;

class Blog extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 10;
        $start = ($page - 1) * $limit;

        $data['posts'] = array_map(function ($post) {
            $post['href'] = $this->url->link('cms/blog.info', 'blog_id=' . $post['post_id']);
            return $post;
        }, $this->model_cms_blog->getPosts(['start' => $start, 'limit' => $limit]));
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_read_more'] = $this->language->get('text_read_more');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $this->response->setOutput($this->load->view('cms/blog_list', $data));
    }

    public function info(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');

        $post_id = (int)($this->request->get['blog_id'] ?? 0);
        $slug = $this->request->get['slug'] ?? null;

        $post = $slug ? $this->model_cms_blog->getPostBySlug($slug) : $this->model_cms_blog->getPost($post_id);

        if (!$post) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }

        $data['post'] = $post;
        $data['heading_title'] = $post['title'];
        $data['text_read_more'] = $this->language->get('text_read_more');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $this->response->setOutput($this->load->view('cms/blog_post', $data));
    }
}
