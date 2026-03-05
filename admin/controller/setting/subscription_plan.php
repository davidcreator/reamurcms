<?php
namespace Reamur\Admin\Controller\Setting;

class SubscriptionPlan extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('setting/subscription_plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/subscription_plan');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_period'] = $this->language->get('column_period');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $plans = $this->model_setting_subscription_plan->getPlans();
        $data['plans'] = array_map(function ($p) {
            $user_token = $this->session->data['user_token'];
            $p['edit'] = $this->url->link('setting/subscription_plan.form', 'user_token=' . $user_token . '&plan_id=' . $p['plan_id']);
            return $p;
        }, $plans);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('setting/subscription_plan.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('setting/subscription_plan.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            ['text' => $this->language->get('text_home'), 'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])],
            ['text' => $this->language->get('heading_title'), 'href' => $this->url->link('setting/subscription_plan', 'user_token=' . $data['user_token'])]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('setting/subscription_plan_list', $data));
    }

    public function form(): void {
        $this->load->language('setting/subscription_plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/subscription_plan');

        $plan_id = (int)($this->request->get['plan_id'] ?? 0);
        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $data = $this->request->post;
            if ($plan_id) {
                $this->model_setting_subscription_plan->edit($plan_id, $data);
            } else {
                $plan_id = $this->model_setting_subscription_plan->add($data);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('setting/subscription_plan', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('setting/subscription_plan.form', 'user_token=' . $data['user_token'] . ($plan_id ? '&plan_id=' . $plan_id : ''));
        $data['cancel'] = $this->url->link('setting/subscription_plan', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;

        if ($plan_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['plan'] = $this->model_setting_subscription_plan->getPlan($plan_id);
        } else {
            $data['plan'] = $this->request->post ?? [
                'code' => '',
                'name' => '',
                'description' => '',
                'price' => 0,
                'currency' => 'BRL',
                'period_days' => 30,
                'status' => 1
            ];
        }

        $data['breadcrumbs'] = [
            ['text' => $this->language->get('text_home'), 'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])],
            ['text' => $this->language->get('heading_title'), 'href' => $this->url->link('setting/subscription_plan', 'user_token=' . $data['user_token'])]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('setting/subscription_plan_form', $data));
    }

    public function delete(): void {
        $this->load->language('setting/subscription_plan');
        $this->load->model('setting/subscription_plan');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_setting_subscription_plan->delete((int)$id);
        }
        $this->response->redirect($this->url->link('setting/subscription_plan', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'setting/subscription_plan')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['name'])) {
            $this->error['name'] = $this->language->get('error_name');
        }
        if (empty($this->request->post['code'])) {
            $this->error['code'] = $this->language->get('error_code');
        }
        return !$this->error;
    }
}
