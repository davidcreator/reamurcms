<?php
namespace Reamur\Admin\Controller\Cms;

class MoocInstructor extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/mooc_instructor');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_instructor');
        $this->model_cms_mooc_instructor->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_form'] = $this->language->get('text_form');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_approved'] = $this->language->get('text_approved');
        $data['text_pending'] = $this->language->get('text_pending');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_headline'] = $this->language->get('column_headline');
        $data['column_user'] = $this->language->get('column_user');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
        $data['button_approve'] = $this->language->get('button_approve');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $instructors = $this->model_cms_mooc_instructor->getInstructors(['start' => $start, 'limit' => $limit]);

        $data['instructors'] = array_map(function ($instructor) {
            $user_token = $this->session->data['user_token'];
            $instructor['edit'] = $this->url->link('cms/mooc_instructor.form', 'user_token=' . $user_token . '&instructor_id=' . $instructor['instructor_id']);
            return $instructor;
        }, $instructors);

        $data['total'] = $this->model_cms_mooc_instructor->getTotalInstructors();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/mooc_instructor.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/mooc_instructor.delete', 'user_token=' . $data['user_token']);
        $data['approve'] = $this->url->link('cms/mooc_instructor.approve', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_instructor', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_instructor_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/mooc_instructor');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_instructor');
        $this->model_cms_mooc_instructor->ensureTables();

        $instructor_id = (int)($this->request->get['instructor_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            if ($instructor_id) {
                $this->model_cms_mooc_instructor->edit($instructor_id, $payload);
            } else {
                $instructor_id = $this->model_cms_mooc_instructor->add($payload);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/mooc_instructor', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/mooc_instructor.form', 'user_token=' . $data['user_token'] . ($instructor_id ? '&instructor_id=' . $instructor_id : ''));
        $data['cancel'] = $this->url->link('cms/mooc_instructor', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;

        if ($instructor_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['instructor'] = $this->model_cms_mooc_instructor->getInstructor($instructor_id);
        } else {
            $data['instructor'] = $this->request->post ?? [
                'name' => '',
                'bio' => '',
                'photo' => '',
                'headline' => '',
                'linkedin' => '',
                'twitter' => '',
                'website' => '',
                'user_id' => ''
            ];
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_instructor', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_instructor_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/mooc_instructor');
        $this->load->model('cms/mooc_instructor');

        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_instructor->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/mooc_instructor', 'user_token=' . $this->session->data['user_token']));
    }

    public function approve(): void {
        $this->load->language('cms/mooc_instructor');
        $this->load->model('cms/mooc_instructor');

        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_instructor->approve((int)$id);
        }
        $this->session->data['success'] = $this->language->get('text_success_approved');
        $this->response->redirect($this->url->link('cms/mooc_instructor', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/mooc_instructor')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['name'])) {
            $this->error['name'] = $this->language->get('error_name');
        }
        return !$this->error;
    }
}
