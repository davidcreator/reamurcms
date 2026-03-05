<?php
namespace Reamur\Catalog\Controller\Cms;

class Blog extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $this->load->model('tool/image');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 10;
        $start = ($page - 1) * $limit;

        $placeholder = $this->model_tool_image->resize('no_image.png', 400, 250);

        $data['posts'] = array_map(function ($post) use ($placeholder) {
            if (!empty($post['featured_image']) && is_file(DIR_IMAGE . $post['featured_image'])) {
                $post['thumb'] = $this->model_tool_image->resize($post['featured_image'], 400, 250);
            } else {
                $post['thumb'] = $placeholder;
            }
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
        $this->load->model('tool/image');

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
        $data['text_buy_course'] = $this->language->get('text_buy_course');
        $data['text_payment_required'] = $this->language->get('text_payment_required');

        $metaTitle = $post['meta_title'] ?? '';
        $this->document->setTitle($metaTitle !== '' ? $metaTitle : $post['title']);
        if (!empty($post['meta_description'] ?? '')) {
            $this->document->setDescription($post['meta_description']);
        }
        if (!empty($post['meta_keyword'] ?? '')) {
            $this->document->setKeywords($post['meta_keyword']);
        }

        if (!empty($post['featured_image'] ?? '') && is_file(DIR_IMAGE . $post['featured_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($post['featured_image'], 800, 450);
            $data['thumb_small'] = $this->model_tool_image->resize($post['featured_image'], 400, 250);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 800, 450);
            $data['thumb_small'] = $this->model_tool_image->resize('no_image.png', 400, 250);
        }

        if (!empty($post['is_premium'])) {
            $this->load->model('checkout/payment');
            $this->load->model('account/subscription');
            $activeSub = $this->customer->isLogged() ? $this->model_account_subscription->getActive($this->customer->getId()) : [];
            $paid = $this->customer->isLogged() ? $this->model_checkout_payment->getByContext('blog', (int)$post['post_id'], $this->customer->getId()) : [];
            $data['access_granted'] = !$post['price'] || $activeSub || $paid;
            $data['purchase_link'] = $this->url->link('checkout/content_payment.checkout', 'context=blog&ref=' . $post['post_id']);
        } else {
            $data['access_granted'] = true;
        }

        if (!$data['access_granted']) {
            $data['post']['description'] = '<p>' . $data['text_payment_required'] . '</p>';
        }

        $this->response->setOutput($this->load->view('cms/blog_post', $data));
    }
}

