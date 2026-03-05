<?php
namespace Reamur\Admin\Controller\Cms;

class MoocQuiz extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/mooc_quiz');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_quiz');
        $this->load->model('cms/mooc_lesson');

        $this->model_cms_mooc_quiz->ensureTables();

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;
        $filter_lesson_id = (int)($this->request->get['lesson_id'] ?? 0);

        $quizzes = $this->model_cms_mooc_quiz->getQuizzes([
            'start' => $start,
            'limit' => $limit,
            'lesson_id' => $filter_lesson_id
        ]);

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_title'] = $this->language->get('column_title');
        $data['column_lesson'] = $this->language->get('column_lesson');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['quizzes'] = array_map(function ($quiz) {
            $user_token = $this->session->data['user_token'];
            $quiz['edit'] = $this->url->link('cms/mooc_quiz.form', 'user_token=' . $user_token . '&quiz_id=' . $quiz['quiz_id']);
            return $quiz;
        }, $quizzes);

        $data['total'] = $this->model_cms_mooc_quiz->getTotalQuizzes(['lesson_id' => $filter_lesson_id]);
        $data['page'] = $page;
        $data['filter_lesson_id'] = $filter_lesson_id;
        $data['lessons'] = $this->model_cms_mooc_lesson->getLessons(['start' => 0, 'limit' => 1000]);
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/mooc_quiz.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/mooc_quiz.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_quiz', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_quiz_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/mooc_quiz');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_quiz');
        $this->load->model('cms/mooc_lesson');

        $this->model_cms_mooc_quiz->ensureTables();

        $quiz_id = (int)($this->request->get['quiz_id'] ?? 0);

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_single'] = $this->language->get('text_single');
        $data['text_multiple'] = $this->language->get('text_multiple');
        $data['text_true_false'] = $this->language->get('text_true_false');
        $data['text_text'] = $this->language->get('text_text');
        $data['text_file'] = $this->language->get('text_file');
        $data['entry_lesson'] = $this->language->get('entry_lesson');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_passing'] = $this->language->get('entry_passing');
        $data['entry_time_limit'] = $this->language->get('entry_time_limit');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_questions'] = $this->language->get('entry_questions');
        $data['entry_type'] = $this->language->get('entry_type');
        $data['entry_options'] = $this->language->get('entry_options');
        $data['entry_correct'] = $this->language->get('entry_correct');
        $data['entry_points'] = $this->language->get('entry_points');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_manual_review'] = $this->language->get('entry_manual_review');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            if ($quiz_id) {
                $this->model_cms_mooc_quiz->edit($quiz_id, $payload);
            } else {
                $quiz_id = $this->model_cms_mooc_quiz->add($payload);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/mooc_quiz', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/mooc_quiz.form', 'user_token=' . $data['user_token'] . ($quiz_id ? '&quiz_id=' . $quiz_id : ''));
        $data['cancel'] = $this->url->link('cms/mooc_quiz', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;
        $data['lessons'] = $this->model_cms_mooc_lesson->getLessons(['start' => 0, 'limit' => 1000]);

        if ($quiz_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['quiz'] = $this->model_cms_mooc_quiz->getQuiz($quiz_id);
        } else {
            $data['quiz'] = $this->request->post ?? [
                'lesson_id' => '',
                'title' => '',
                'description' => '',
                'passing_score' => 70,
                'time_limit_seconds' => '',
                'status' => 1,
                'questions' => []
            ];
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_quiz', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_quiz_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/mooc_quiz');
        $this->load->model('cms/mooc_quiz');

        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_quiz->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/mooc_quiz', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/mooc_quiz')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['lesson_id'])) {
            $this->error['lesson_id'] = $this->language->get('error_lesson');
        }
        if (empty($this->request->post['title'])) {
            $this->error['title'] = $this->language->get('error_title');
        }
        return !$this->error;
    }
}
