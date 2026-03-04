<?php
namespace Reamur\Admin\Controller\Cms;

class BlogComment extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/blog');
        $this->document->setTitle($this->language->get('text_blog_comments'));

        $this->load->model('cms/blog_comment');
        $this->model_cms_blog_comment->ensureTables();

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;
        $status = $this->request->get['status'] ?? '';
        $q = $this->request->get['q'] ?? '';

        $filters = ['start' => $start, 'limit' => $limit, 'status' => $status, 'q' => $q];
        $comments = $this->model_cms_blog_comment->getComments($filters);
        $total = $this->model_cms_blog_comment->getTotal($filters);

        $data['comments'] = array_map(function ($c) {
            $c['status_label'] = $this->statusLabel((int)$c['status']);
            $c['post_link'] = $this->url->link('cms/blog_post.form', 'user_token=' . $this->session->data['user_token'] . '&post_id=' . $c['blog_post_id']);
            return $c;
        }, $comments);

        $data['filter_status'] = $status;
        $data['filter_q'] = $q;
        $data['total'] = $total;
        $data['page'] = $page;
        $data['limit'] = $limit;

        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['heading_title'] = $this->language->get('text_blog_comments');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_pending'] = $this->language->get('text_pending');
        $data['text_spam'] = $this->language->get('text_spam');
        $data['text_blocked'] = $this->language->get('text_blocked');
        $data['button_approve'] = $this->language->get('button_approve');
        $data['button_disapprove'] = $this->language->get('button_disapprove');
        $data['button_spam'] = $this->language->get('button_spam');
        $data['button_block'] = $this->language->get('button_block');
        $data['button_delete'] = $this->language->get('button_delete');

        $data['approve'] = $this->url->link('cms/blog_comment.approve', 'user_token=' . $this->session->data['user_token']);
        $data['disapprove'] = $this->url->link('cms/blog_comment.disapprove', 'user_token=' . $this->session->data['user_token']);
        $data['spam'] = $this->url->link('cms/blog_comment.spam', 'user_token=' . $this->session->data['user_token']);
        $data['block'] = $this->url->link('cms/blog_comment.block', 'user_token=' . $this->session->data['user_token']);
        $data['delete'] = $this->url->link('cms/blog_comment.delete', 'user_token=' . $this->session->data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
            ],
            [
                'text' => $this->language->get('text_blog_comments'),
                'href' => $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/blog_comment_list', $data));
    }

    public function approve(): void { $this->updateStatusBulk(1); }
    public function disapprove(): void { $this->updateStatusBulk(0); }
    public function spam(): void { $this->updateStatusBulk(2); }
    public function block(): void { $this->updateStatusBulk(3); }

    public function delete(): void {
        $this->load->model('cms/blog_comment');
        $ids = $this->request->post['selected'] ?? [];
        $this->model_cms_blog_comment->delete($ids);
        $this->response->redirect($this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token']));
    }

    private function updateStatusBulk(int $status): void {
        $this->load->model('cms/blog_comment');
        $ids = $this->request->post['selected'] ?? [];
        $this->model_cms_blog_comment->updateStatus($ids, $status);
        $this->response->redirect($this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token']));
    }

    private function statusLabel(int $status): string {
        return match ($status) {
            1 => $this->language->get('text_enabled'),
            2 => $this->language->get('text_spam'),
            3 => $this->language->get('text_blocked'),
            default => $this->language->get('text_pending')
        };
    }
}
