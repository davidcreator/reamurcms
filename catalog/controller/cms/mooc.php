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
        $data['text_instructor'] = $this->language->get('text_instructor');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_progress'] = $this->language->get('text_progress');
        $data['text_final_score'] = $this->language->get('text_final_score');
        $data['text_time_spent'] = $this->language->get('text_time_spent');
        $data['text_certificate'] = $this->language->get('text_certificate');

        $this->response->setOutput($this->load->view('cms/mooc_list', $data));
    }

    public function info(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc');
        $this->load->model('cms/mooc_enrollment');
        $this->load->model('cms/mooc_lesson');

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
        $data['text_instructor'] = $this->language->get('text_instructor');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_progress'] = $this->language->get('text_progress');
        $data['text_final_score'] = $this->language->get('text_final_score');
        $data['text_time_spent'] = $this->language->get('text_time_spent');
        $data['text_enroll'] = $this->language->get('text_enroll');
        $data['text_enrolled'] = $this->language->get('text_enrolled');
        $data['text_lessons'] = $this->language->get('text_lessons');
        $data['text_requires_login'] = $this->language->get('text_requires_login');
        $data['text_start_course'] = $this->language->get('text_start_course');
        $data['text_continue_course'] = $this->language->get('text_continue_course');
        $data['text_no_lessons'] = $this->language->get('text_no_lessons');

        $customer_id = $this->customer->getId();
        $enrollment = $customer_id ? $this->model_cms_mooc_enrollment->getEnrollment($course['course_id'], $customer_id) : [];
        $data['customer_logged'] = (bool)$customer_id;
        $data['is_enrolled'] = !empty($enrollment);
        $data['progress'] = $enrollment['progress_percent'] ?? 0;
        $data['final_score'] = $enrollment['final_score'] ?? null;
        $data['time_spent_seconds'] = $enrollment['time_spent_seconds'] ?? 0;
        $data['enroll_action'] = $this->url->link('cms/mooc.enroll', 'course_id=' . $course['course_id']);
        $data['login_link'] = $this->url->link('account/login', 'language=' . $this->config->get('config_language') . '&redirect=' . urlencode($this->url->link('cms/mooc.info', 'course_id=' . $course['course_id'])));
        if ($data['is_enrolled']) {
            $lessons = $this->model_cms_mooc_lesson->getLessonsByCourse($course['course_id']);
            $lesson_progress = $this->model_cms_mooc_enrollment->getLessonProgresses($course['course_id'], $customer_id);
            $data['lessons'] = array_map(function ($lesson) use ($lesson_progress) {
                $lesson['href'] = $this->url->link('cms/mooc.lesson', 'course_id=' . $lesson['course_id'] . '&lesson_id=' . $lesson['lesson_id']);
                $lp = $lesson_progress[$lesson['lesson_id']] ?? [];
                $lesson['progress_status'] = $lp['status'] ?? 'not_started';
                $lesson['time_spent_seconds'] = $lp['time_spent_seconds'] ?? 0;
                $lesson['score'] = $lp['score'] ?? null;
                return $lesson;
            }, $lessons);
            $data['certificate_link'] = $this->url->link('cms/mooc.certificate', 'course_id=' . $course['course_id']);
        } else {
            $data['lessons'] = [];
        }
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $this->response->setOutput($this->load->view('cms/mooc_course', $data));
    }

    public function enroll(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc');
        $this->load->model('cms/mooc_enrollment');

        $course_id = (int)($this->request->get['course_id'] ?? 0);

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('cms/mooc.info', 'course_id=' . $course_id);
            $this->response->redirect($this->url->link('account/login'));
            return;
        }

        $course = $this->model_cms_mooc->getCourse($course_id);
        if (!$course) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }

        $this->model_cms_mooc_enrollment->enroll($course_id, $this->customer->getId());
        $this->session->data['success'] = $this->language->get('text_enrolled_success');

        $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $course_id));
    }

    public function lesson(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc');
        $this->load->model('cms/mooc_enrollment');
        $this->load->model('cms/mooc_lesson');

        $lesson_id = (int)($this->request->get['lesson_id'] ?? 0);
        $course_id = (int)($this->request->get['course_id'] ?? 0);

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('cms/mooc.lesson', 'course_id=' . $course_id . '&lesson_id=' . $lesson_id);
            $this->response->redirect($this->url->link('account/login'));
            return;
        }

        $lesson = $this->model_cms_mooc_lesson->getLesson($lesson_id);
        if (!$lesson || ($course_id && (int)$lesson['course_id'] !== $course_id)) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }

        $course = $this->model_cms_mooc->getCourse((int)$lesson['course_id']);
        $enrollment = $this->model_cms_mooc_enrollment->getEnrollment((int)$lesson['course_id'], $this->customer->getId());

        if (!$enrollment) {
            $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $lesson['course_id']));
            return;
        }

        $content = $this->model_cms_mooc_lesson->getLessonContent($lesson_id);

        $data['course'] = $course;
        $data['lesson'] = $lesson;
        $data['content'] = $content;
        $data['text_resources'] = $this->language->get('text_resources');
        $data['text_download'] = $this->language->get('text_download');
        $data['text_back_to_course'] = $this->language->get('text_back_to_course');
        $data['text_no_lessons'] = $this->language->get('text_no_lessons');
        $data['course_link'] = $this->url->link('cms/mooc.info', 'course_id=' . $lesson['course_id']);

        $this->response->setOutput($this->load->view('cms/mooc_lesson', $data));
    }

    public function progress(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $course_id = (int)($this->request->post['course_id'] ?? 0);
        $lesson_id = (int)($this->request->post['lesson_id'] ?? 0);
        $status = $this->request->post['status'] ?? 'in_progress';
        $time_spent = (int)($this->request->post['time_spent_seconds'] ?? 0);
        $score = $this->request->post['score'] ?? null;

        if ($course_id && $lesson_id) {
            $this->load->model('cms/mooc_enrollment');
            $this->model_cms_mooc_enrollment->updateLessonProgress($course_id, $this->customer->getId(), $lesson_id, $status, $time_spent, $score);
        }
        $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $course_id));
    }

    public function my(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_enrollment');

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('cms/mooc.my');
            $this->response->redirect($this->url->link('account/login'));
            return;
        }

        $enrollments = $this->model_cms_mooc_enrollment->getEnrollmentsByCustomer($this->customer->getId());
        $data['heading_title'] = $this->language->get('text_my_courses');
        $data['text_no_enrollments'] = $this->language->get('text_no_enrollments');
        $data['text_progress'] = $this->language->get('text_progress');
        $data['text_view_course'] = $this->language->get('text_view_course');

        $data['enrollments'] = array_map(function ($row) {
            $row['href'] = $this->url->link('cms/mooc.info', 'course_id=' . $row['course_id']);
            return $row;
        }, $enrollments);

        $this->response->setOutput($this->load->view('cms/mooc_my', $data));
    }

    public function certificate(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_enrollment');
        $this->load->model('cms/mooc');

        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }

        $course_id = (int)($this->request->get['course_id'] ?? 0);
        $enrollment = $this->model_cms_mooc_enrollment->getEnrollment($course_id, $this->customer->getId());
        if (!$enrollment || (int)($enrollment['progress_percent'] ?? 0) < 100) {
            $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $course_id));
            return;
        }

        $this->model_cms_mooc_enrollment->ensureCertificateForEnrollment((int)$enrollment['enrollment_id']);

        $cert = $this->db->query("SELECT cert.*, c.title AS course_title, c.duration_minutes,
            GROUP_CONCAT(DISTINCT instr.name ORDER BY instr.name SEPARATOR ', ') AS instructors
            FROM `" . DB_PREFIX . "mooc_certificate` cert
            JOIN `" . DB_PREFIX . "mooc_enrollment` e ON e.enrollment_id = cert.enrollment_id
            JOIN `" . DB_PREFIX . "mooc_course` c ON c.course_id = e.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_course_instructor` ci ON ci.course_id = c.course_id
            LEFT JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
            WHERE cert.enrollment_id = '" . (int)$enrollment['enrollment_id'] . "'
            GROUP BY cert.certificate_id")->row;

        $data['certificate'] = $cert;
        $data['student_name'] = trim($this->customer->getFirstName() . ' ' . $this->customer->getLastName());
        $data['text_certificate'] = $this->language->get('text_certificate');
        $data['text_duration'] = $this->language->get('text_duration');
        $data['text_instructor'] = $this->language->get('text_instructor');
        $data['text_code'] = $this->language->get('text_code');
        $data['text_verify'] = $this->language->get('text_verify');
        $data['verify_link'] = $this->url->link('cms/mooc.verify', 'code=' . $cert['certificate_code']);
        $data['qr_src'] = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($data['verify_link']);

        $this->response->setOutput($this->load->view('cms/mooc_certificate', $data));
    }

    public function verify(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_enrollment');

        $code = $this->request->get['code'] ?? '';
        $cert = $code ? $this->model_cms_mooc_enrollment->getCertificateByCode($code) : [];

        if (!$cert) {
            $this->response->setOutput('<p>Certificado não encontrado.</p>');
            return;
        }

        $data['certificate'] = $cert;
        $data['student_name'] = '';
        $data['text_certificate'] = $this->language->get('text_certificate');
        $data['text_duration'] = $this->language->get('text_duration');
        $data['text_instructor'] = $this->language->get('text_instructor');
        $data['text_code'] = $this->language->get('text_code');
        $data['verify_link'] = $this->url->link('cms/mooc.verify', 'code=' . $code);
        $data['qr_src'] = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($data['verify_link']);

        $this->response->setOutput($this->load->view('cms/mooc_certificate', $data));
    }
}
