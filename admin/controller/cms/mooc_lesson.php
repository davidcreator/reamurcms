<?php
namespace Reamur\Admin\Controller\Cms;

class MoocLesson extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/mooc_lesson');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_lesson');
        $this->load->model('cms/mooc_course');

        $this->model_cms_mooc_lesson->ensureTables();

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;
        $filter_course_id = (int)($this->request->get['course_id'] ?? 0);

        $lessons = $this->model_cms_mooc_lesson->getLessons([
            'start' => $start,
            'limit' => $limit,
            'course_id' => $filter_course_id
        ]);

        $data['lessons'] = array_map(function ($lesson) {
            $user_token = $this->session->data['user_token'];
            $lesson['edit'] = $this->url->link('cms/mooc_lesson.form', 'user_token=' . $user_token . '&lesson_id=' . $lesson['lesson_id']);
            return $lesson;
        }, $lessons);
        $data['total'] = $this->model_cms_mooc_lesson->getTotalLessons(['course_id' => $filter_course_id]);
        $data['page'] = $page;
        $data['filter_course_id'] = $filter_course_id;
        $data['courses'] = $this->model_cms_mooc_course->getCourses(['start' => 0, 'limit' => 1000]);
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/mooc_lesson.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/mooc_lesson.delete', 'user_token=' . $data['user_token']);
        $data['text_list'] = $this->language->get('text_list');
        $data['text_form'] = $this->language->get('text_form');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_video'] = $this->language->get('text_video');
        $data['text_article'] = $this->language->get('text_article');
        $data['text_quiz'] = $this->language->get('text_quiz');
        $data['text_live'] = $this->language->get('text_live');
        $data['text_slides'] = $this->language->get('text_slides');
        $data['text_pdf'] = $this->language->get('text_pdf');
        $data['text_link'] = $this->language->get('text_link');
        $data['text_download'] = $this->language->get('text_download');

        $query_filter = $filter_course_id ? '&course_id=' . $filter_course_id : '';
        $data['pagination'] = $this->url->link('cms/mooc_lesson', 'user_token=' . $data['user_token'] . $query_filter . '&page={page}');

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_lesson', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_lesson_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/mooc_lesson');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_lesson');
        $this->load->model('cms/mooc_course');

        $this->model_cms_mooc_lesson->ensureTables();

        $lesson_id = (int)($this->request->get['lesson_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            if (empty($payload['slug']) && !empty($payload['title'])) {
                $payload['slug'] = $this->slugify($payload['title']);
            }
            if ($lesson_id) {
                $this->model_cms_mooc_lesson->edit($lesson_id, $payload);
            } else {
                $lesson_id = $this->model_cms_mooc_lesson->add($payload);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/mooc_lesson', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/mooc_lesson.form', 'user_token=' . $data['user_token'] . ($lesson_id ? '&lesson_id=' . $lesson_id : ''));
        $data['cancel'] = $this->url->link('cms/mooc_lesson', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;
        $data['courses'] = $this->model_cms_mooc_course->getCourses(['start' => 0, 'limit' => 1000]);
        $data['entry_course'] = $this->language->get('entry_course');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_summary'] = $this->language->get('entry_summary');
        $data['entry_content_type'] = $this->language->get('entry_content_type');
        $data['entry_video_url'] = $this->language->get('entry_video_url');
        $data['entry_external_url'] = $this->language->get('entry_external_url');
        $data['entry_duration'] = $this->language->get('entry_duration');
        $data['entry_min_time'] = $this->language->get('entry_min_time');
        $data['entry_auto_complete'] = $this->language->get('entry_auto_complete');
        $data['entry_comments'] = $this->language->get('entry_comments');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_release_at'] = $this->language->get('entry_release_at');
        $data['entry_content'] = $this->language->get('entry_content');
        $data['entry_resources'] = $this->language->get('entry_resources');
        $data['entry_attachment'] = $this->language->get('entry_attachment');

        if ($lesson_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['lesson'] = $this->model_cms_mooc_lesson->getLesson($lesson_id);
        } else {
            $data['lesson'] = $this->request->post ?? [
                'course_id' => '',
                'title' => '',
                'slug' => '',
                'summary' => '',
                'content_type' => 'video',
                'video_url' => '',
                'external_url' => '',
                'duration_minutes' => 0,
                'min_seconds' => 0,
                'auto_complete' => 0,
                'comments_enabled' => 1,
                'sort_order' => 0,
                'status' => 1,
                'release_at' => '',
                'content' => '',
                'resources' => '',
                'attachment' => ''
            ];
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_lesson', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_lesson_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/mooc_lesson');
        $this->load->model('cms/mooc_lesson');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_lesson->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/mooc_lesson', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/mooc_lesson')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['title'])) {
            $this->error['title'] = $this->language->get('error_title');
        }
        if (empty($this->request->post['course_id'])) {
            $this->error['course_id'] = $this->language->get('error_course');
        }
        return !$this->error;
    }

    private function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        return trim($text, '-');
    }
}
