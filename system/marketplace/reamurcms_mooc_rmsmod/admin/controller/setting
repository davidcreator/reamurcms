<?php
namespace Reamur\Admin\Controller\Setting;

class PaymentSplit extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('setting/payment_split');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('payment', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('setting/payment_split', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['entry_platform_fee'] = $this->language->get('entry_platform_fee');
        $data['entry_stripe_secret'] = $this->language->get('entry_stripe_secret');
        $data['entry_stripe_public'] = $this->language->get('entry_stripe_public');
        $data['entry_mp_token'] = $this->language->get('entry_mp_token');
        $data['entry_default_stripe'] = $this->language->get('entry_default_stripe');
        $data['entry_default_mp'] = $this->language->get('entry_default_mp');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['error_warning'] = $this->error['warning'] ?? '';

        $data['payment_platform_fee'] = $this->request->post['payment_platform_fee'] ?? $this->config->get('payment_platform_fee');
        $data['payment_stripe_secret'] = $this->request->post['payment_stripe_secret'] ?? $this->config->get('payment_stripe_secret');
        $data['payment_stripe_public'] = $this->request->post['payment_stripe_public'] ?? $this->config->get('payment_stripe_public');
        $data['payment_mp_access_token'] = $this->request->post['payment_mp_access_token'] ?? $this->config->get('payment_mp_access_token');
        $data['payment_default_stripe_account'] = $this->request->post['payment_default_stripe_account'] ?? $this->config->get('payment_default_stripe_account');
        $data['payment_default_mp_user'] = $this->request->post['payment_default_mp_user'] ?? $this->config->get('payment_default_mp_user');

        $data['action'] = $this->url->link('setting/payment_split', 'user_token=' . $this->session->data['user_token']);
        $data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token']);

        $data['breadcrumbs'] = [
            ['text' => $this->language->get('text_home'), 'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])],
            ['text' => $this->language->get('heading_title'), 'href' => $this->url->link('setting/payment_split', 'user_token=' . $this->session->data['user_token'])]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('setting/payment_split', $data));
    }

    private function validate(): bool {
        if (!$this->user->hasPermission('modify', 'setting/payment_split')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
