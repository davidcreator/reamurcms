<?php
namespace Reamur\Admin\Controller\Cms;

class BlogStats extends \Reamur\System\Engine\Controller {
    public function index(): void {
        // reuse blog_post permission
        if (!$this->user->hasPermission('access', 'cms/blog_post')) {
            $this->response->redirect($this->url->link('error/permission', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('text_blog_stats'));

        $this->load->model('cms/blog_stats');

        $data['heading_title'] = $this->language->get('text_blog_stats');
        $data['text_blog_views'] = $this->language->get('text_blog_views');
        $data['text_blog_unique_views'] = $this->language->get('text_blog_unique_views');
        $data['text_blog_likes'] = $this->language->get('text_blog_likes');
        $data['text_blog_shares'] = $this->language->get('text_blog_shares');
        $data['text_blog_top_posts'] = $this->language->get('text_blog_top_posts');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['summary'] = $this->model_cms_blog_stats->getSummary();
        $data['top_posts'] = $this->model_cms_blog_stats->getTopPosts(10);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
            ],
            [
                'text' => $this->language->get('text_blog_stats'),
                'href' => $this->url->link('cms/blog_stats', 'user_token=' . $this->session->data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_stats', $data));
    }
}
