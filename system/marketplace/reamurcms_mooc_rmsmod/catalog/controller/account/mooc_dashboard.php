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
        $this->load->model('cms/mooc_notification');
        $this->load->model('cms/mooc_gamification');

        $customer_id = $this->customer->getId();

        $mark_id = (int)($this->request->get['notification_id'] ?? 0);
        if ($mark_id) {
            $this->model_cms_mooc_notification->markRead($mark_id, $customer_id);
            $this->response->redirect($this->url->link('account/mooc_dashboard'));
            return;
        }

        $enrollments = $this->model_cms_mooc_enrollment->getEnrollmentsByCustomer($customer_id);
        $course_ids = array_column($enrollments, 'course_id');

        // Recommended: published courses not yet enrolled
        $recommended = $this->model_cms_mooc->getCourses(['start' => 0, 'limit' => 6]);
        $recommended = array_filter($recommended, fn($c) => !in_array((int)$c['course_id'], $course_ids, true));

        $certificates = $this->model_cms_mooc_enrollment->getCertificatesByCustomer($customer_id);
        $notifications = $this->model_cms_mooc_notification->getNotifications($customer_id, 10);
        $gamification = $this->model_cms_mooc_gamification->getStats($customer_id);
        $leaderboard = $this->model_cms_mooc_gamification->getLeaderboard(5);
        $goals = $this->model_cms_mooc_gamification->getGoals($customer_id);

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_my_courses'] = $this->language->get('text_my_courses');
        $data['text_recommended'] = $this->language->get('text_recommended');
        $data['text_certificates'] = $this->language->get('text_certificates');
        $data['text_progress'] = $this->language->get('text_progress');
        $data['text_history'] = $this->language->get('text_history');
        $data['text_profile'] = $this->language->get('text_profile');
        $data['text_view'] = $this->language->get('text_view');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_notifications'] = $this->language->get('text_notifications');
        $data['text_mark_read'] = $this->language->get('text_mark_read');
        $data['text_no_notifications'] = $this->language->get('text_no_notifications');
        $data['text_points'] = $this->language->get('text_points');
        $data['text_streak'] = $this->language->get('text_streak');
        $data['text_badges'] = $this->language->get('text_badges');
        $data['text_leaderboard'] = $this->language->get('text_leaderboard');
        $data['text_goals'] = $this->language->get('text_goals');
        $data['text_goal_progress'] = $this->language->get('text_goal_progress');

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

        $data['notifications'] = array_map(function ($row) {
            $row['mark_href'] = $this->url->link('account/mooc_dashboard', 'notification_id=' . $row['notification_id']);
            return $row;
        }, $notifications);
        $data['gamification'] = $gamification;
        $data['leaderboard'] = $leaderboard;
        $data['goals'] = $goals;

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
