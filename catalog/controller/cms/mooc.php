<?php
namespace Reamur\Catalog\Controller\Cms;

class Mooc extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 10;
        $start = ($page - 1) * $limit;

        $data['courses'] = array_map(function ($course) {
            $course['href'] = $this->url->link('cms/mooc.info', 'course_id=' . $course['course_id']);
            return $course;
        }, $this->model_cms_mooc->getCourses(['start' => $start, 'limit' => $limit]));
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_duration'] = $this->language->get('text_duration');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_free'] = $this->language->get('text_free');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_level'] = $this->language->get('text_level');

        $this->response->setOutput($this->load->view('cms/mooc_list', $data));
    }

    public function info(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc');

        $course_id = (int)($this->request->get['course_id'] ?? 0);
        $slug = $this->request->get['slug'] ?? null;

        $course = $slug ? $this->model_cms_mooc->getCourseBySlug($slug) : $this->model_cms_mooc->getCourse($course_id);

        if (!$course) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }

        $data['course'] = $course;
        $data['heading_title'] = $course['title'];
        $data['text_duration'] = $this->language->get('text_duration');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_free'] = $this->language->get('text_free');
        $data['text_level'] = $this->language->get('text_level');

        $this->response->setOutput($this->load->view('cms/mooc_course', $data));
    }
}
