<?php
namespace Reamur\Catalog\Controller\Account;

class Subscription extends \Reamur\System\Engine\Controller {
    public function index(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $this->load->language('account/subscription');
        $this->load->model('account/subscription');
        $this->load->model('checkout/payment');

        $customer_id = $this->customer->getId();
        $plans = $this->model_account_subscription->getPlans();
        $active = $this->model_account_subscription->getActive($customer_id);

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_choose_plan'] = $this->language->get('text_choose_plan');
        $data['text_active_until'] = $this->language->get('text_active_until');
        $data['text_subscribe'] = $this->language->get('text_subscribe');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_no_plans'] = $this->language->get('text_no_plans');
        $data['plans'] = $plans;
        $data['active'] = $active;
        $data['action'] = $this->url->link('account/subscription.subscribe');

        $this->response->setOutput($this->load->view('account/subscription_list', $data));
    }

    public function subscribe(): void {
        $this->load->language('account/subscription');
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $plan_id = (int)($this->request->post['plan_id'] ?? 0);
        $method = $this->request->post['method'] ?? 'stripe';
        $this->load->model('account/subscription');
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');

        $plans = $this->model_account_subscription->getPlans();
        $plan = null;
        foreach ($plans as $p) { if ((int)$p['plan_id'] === $plan_id) { $plan = $p; break; } }
        if (!$plan) {
            $this->response->redirect($this->url->link('account/subscription'));
            return;
        }
        $payment_id = $this->model_checkout_payment->create($this->customer->getId(), 'subscription', $plan_id, $method, (float)$plan['price'], $plan['currency']);
        $success = $this->url->link('account/subscription.success', 'payment_id=' . $payment_id . '&method=' . $method, true);
        $cancel = $this->url->link('account/subscription');
        if ($method === 'stripe') {
            $checkout = $this->model_checkout_gateway->createStripeCheckout((float)$plan['price'], $plan['currency'], $plan['name'], $success . '&session_id={CHECKOUT_SESSION_ID}', $cancel);
            if (!empty($checkout['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($checkout['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($checkout['url'] ?? $cancel);
                return;
            }
        } elseif ($method === 'mercadopago') {
            $pref = $this->model_checkout_gateway->createMpPreference((float)$plan['price'], $plan['currency'], $plan['name'], $success . '&preference_id={PREF_ID}', $cancel);
            if (!empty($pref['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($pref['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($pref['init_point'] ?? $cancel);
                return;
            }
        }
        // fallback
        $this->model_checkout_payment->markPaid($payment_id, strtoupper($method) . '-' . $payment_id);
        $this->model_account_subscription->subscribe($this->customer->getId(), $plan_id, $payment_id);
        $this->session->data['success'] = $this->language->get('text_subscribed_success');
        $this->response->redirect($this->url->link('account/subscription'));
    }

    public function success(): void {
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');
        $this->load->model('account/subscription');
        $this->load->language('account/subscription');
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $payment_id = (int)($this->request->get['payment_id'] ?? 0);
        $method = $this->request->get['method'] ?? '';
        $payment = $payment_id ? $this->model_checkout_payment->getPayment($payment_id) : [];
        if (!$payment) {
            $this->response->redirect($this->url->link('account/subscription'));
            return;
        }
        $ok = false;
        if ($method === 'stripe') {
            $session_id = $this->request->get['session_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($session_id) $ok = $this->model_checkout_gateway->verifyStripeSession($session_id);
        } elseif ($method === 'mercadopago') {
            $pref_id = $this->request->get['preference_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($pref_id) $ok = $this->model_checkout_gateway->verifyMpPayment($pref_id);
        }
        if ($ok) {
            $this->model_checkout_payment->markPaid($payment_id, $payment['transaction_ref'] ?? '');
            $this->model_account_subscription->subscribe($this->customer->getId(), (int)$payment['reference_id'], $payment_id);
            $this->session->data['success'] = $this->language->get('text_subscribed_success');
        }
        $this->response->redirect($this->url->link('account/subscription'));
    }
}
