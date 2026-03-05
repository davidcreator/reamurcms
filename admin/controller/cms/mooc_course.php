<?php
namespace Reamur\Admin\Controller\Cms;

class MoocCourse extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/mooc');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_course');
        $this->load->model('cms/mooc_instructor');
        $this->model_cms_mooc_course->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['text_level_beginner'] = $this->language->get('text_level_beginner');
        $data['text_level_intermediate'] = $this->language->get('text_level_intermediate');
        $data['text_level_advanced'] = $this->language->get('text_level_advanced');
        $data['text_level_all'] = $this->language->get('text_level_all');
        $data['column_title'] = $this->language->get('column_title');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_level'] = $this->language->get('column_level');
        $data['column_category'] = $this->language->get('column_category');
        $data['column_instructor'] = $this->language->get('column_instructor');
        $data['column_date'] = $this->language->get('column_date');
        $data['column_action'] = $this->language->get('column_action');
        $data['button_approve'] = $this->language->get('button_approve');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $raw_courses = $this->model_cms_mooc_course->getCourses(['start' => $start, 'limit' => $limit]);
        $user_token = $this->session->data['user_token'];
        $data['courses'] = array_map(function ($course) use ($user_token) {
            $course['edit'] = $this->url->link('cms/mooc_course.form', 'user_token=' . $user_token . '&course_id=' . $course['course_id']);
            return $course;
        }, $raw_courses);
        $data['total'] = $this->model_cms_mooc_course->getTotalCourses();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $user_token;
        $data['add'] = $this->url->link('cms/mooc_course.form', 'user_token=' . $user_token);
        $data['delete'] = $this->url->link('cms/mooc_course.delete', 'user_token=' . $user_token);
        $data['approve'] = $this->url->link('cms/mooc_course.approve', 'user_token=' . $user_token);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_course', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_course_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/mooc');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/mooc_course');
        $this->load->model('cms/mooc_instructor');
        $this->model_cms_mooc_course->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['text_free'] = $this->language->get('text_free');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_duration'] = $this->language->get('entry_duration');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_level'] = $this->language->get('entry_level');
        $data['entry_featured_image'] = $this->language->get('entry_featured_image');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_instructor'] = $this->language->get('entry_instructor');

        $course_id = (int)($this->request->get['course_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            if ($course_id) {
                $this->model_cms_mooc_course->edit($course_id, $payload);
            } else {
                $course_id = $this->model_cms_mooc_course->add($payload);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/mooc_course', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/mooc_course.form', 'user_token=' . $data['user_token'] . ($course_id ? '&course_id=' . $course_id : ''));
        $data['cancel'] = $this->url->link('cms/mooc_course', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;

        if ($course_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['course'] = $this->model_cms_mooc_course->getCourse($course_id);
        } else {
            $data['course'] = $this->request->post ?? [
                'title' => '',
                'slug' => '',
                'subtitle' => '',
                'description' => '',
                'objectives' => '',
                'level' => 'all',
                'language' => 'en',
                'duration_minutes' => 0,
                'price' => 0,
                'is_free' => 1,
                'status' => 'draft',
                'featured_image' => '',
                'published_at' => '',
                'category_ids' => [],
                'instructor_ids' => []
            ];
        }

        if (empty($data['course']['category_ids'])) {
            $data['course']['category_ids'] = $this->model_cms_mooc_course->getCourseCategoryIds($course_id);
        }
        if (empty($data['course']['instructor_ids'])) {
            $data['course']['instructor_ids'] = $this->model_cms_mooc_course->getCourseInstructorIds($course_id);
        }

        $data['categories'] = $this->model_cms_mooc_course->getAllCategories();
        $data['instructors'] = $this->model_cms_mooc_instructor->getApprovedInstructors();

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/mooc_course', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/mooc_course_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_course');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_course->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/mooc_course', 'user_token=' . $this->session->data['user_token']));
    }

    public function approve(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_course');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_mooc_course->approve((int)$id);
        }
        $this->session->data['success'] = $this->language->get('text_success_approved');
        $this->response->redirect($this->url->link('cms/mooc_course', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/mooc_course')) {
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
