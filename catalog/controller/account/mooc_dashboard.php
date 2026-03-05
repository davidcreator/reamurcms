<?php
namespace Reamur\Catalog\Controller\Account;

class MoocDashboard extends \Reamur\System\Engine\Controller {
    public function index(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }

        $this->load->language('account/mooc_dashboard');
        $this->load->model('cms/mooc_enrollment');
        $this->load->model('cms/mooc');

        $customer_id = $this->customer->getId();

        $enrollments = $this->model_cms_mooc_enrollment->getEnrollmentsByCustomer($customer_id);
        $course_ids = array_column($enrollments, 'course_id');

        // Recommended: published courses not yet enrolled
        $recommended = $this->model_cms_mooc->getCourses(['start' => 0, 'limit' => 6]);
        $recommended = array_filter($recommended, fn($c) => !in_array((int)$c['course_id'], $course_ids, true));

        $certificates = $this->model_cms_mooc_enrollment->getCertificatesByCustomer($customer_id);

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_my_courses'] = $this->language->get('text_my_courses');
        $data['text_recommended'] = $this->language->get('text_recommended');
        $data['text_certificates'] = $this->language->get('text_certificates');
        $data['text_progress'] = $this->language->get('text_progress');
        $data['text_history'] = $this->language->get('text_history');
        $data['text_profile'] = $this->language->get('text_profile');
        $data['text_view'] = $this->language->get('text_view');
        $data['text_none'] = $this->language->get('text_none');

        $data['customer_name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
        $data['customer_email'] = $this->customer->getEmail();

        $data['enrollments'] = array_map(function ($row) {
            $row['href'] = $this->url->link('cms/mooc.info', 'course_id=' . $row['course_id']);
            return $row;
        }, $enrollments);

        $data['recommended'] = array_map(function ($row) {
            $row['href'] = $this->url->link('cms/mooc.info', 'course_id=' . $row['course_id']);
            return $row;
        }, $recommended);

        $data['certificates'] = array_map(function ($row) {
            $row['verify'] = $this->url->link('cms/mooc.verify', 'code=' . $row['certificate_code']);
            return $row;
        }, $certificates);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_account'),
                'href' => $this->url->link('account/account')
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('account/mooc_dashboard')
            ]
        ];

        $this->response->setOutput($this->load->view('account/mooc_dashboard', $data));
    }
}
