<?php
namespace Reamur\Catalog\Controller\Checkout;

class PaySplit extends \Reamur\System\Engine\Controller {
    public function checkout(): void {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('checkout/pay_split.checkout');
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $order_id = (int)($this->request->get['order_id'] ?? ($this->session->data['order_id'] ?? 0));
        if (!$order_id) {
            $this->response->redirect($this->url->link('checkout/cart'));
            return;
        }
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);
        if (!$order) {
            $this->response->redirect($this->url->link('checkout/cart'));
            return;
        }
        $this->load->language('cms/mooc');
        $data['item'] = ['title' => 'Pedido #' . $order_id, 'price' => $order['total']];
        $data['action'] = $this->url->link('checkout/pay_split.pay', 'order_id=' . $order_id);
        $data['methods'] = [
            ['code' => 'stripe', 'title' => 'Stripe (cartão / wallets)'],
            ['code' => 'mercadopago', 'title' => 'Mercado Pago (Pix/Boleto/Cartão)']
        ];
        $data['text_payment_methods'] = $this->language->get('text_payment_methods');
        $data['text_pay_now'] = $this->language->get('text_pay_now');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_buy_course'] = $this->language->get('text_buy_course');
        $this->response->setOutput($this->load->view('cms/mooc_checkout', $data));
    }

    public function pay(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $method = $this->request->post['method'] ?? 'stripe';
        $order_id = (int)($this->request->get['order_id'] ?? ($this->session->data['order_id'] ?? 0));
        if (!$order_id) {
            $this->response->redirect($this->url->link('checkout/cart'));
            return;
        }
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);
        if (!$order) {
            $this->response->redirect($this->url->link('checkout/cart'));
            return;
        }
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');
        $products = $this->model_checkout_order->getOrderProducts($order_id);
        $first = $products[0] ?? [];
        $product_id = (int)($first['product_id'] ?? 0);
        $price = (float)$order['total'];
        $owner = $product_id ? $this->db->query("SELECT owner_id, payout_share FROM `" . DB_PREFIX . "product` WHERE product_id='" . $product_id . "'")->row : [];
        $dest = ['stripe' => '', 'mp' => '', 'share' => (float)($owner['payout_share'] ?? ($this->config->get('payment_platform_fee') ? 100 - (float)$this->config->get('payment_platform_fee') : 80))];
        if (!empty($owner['owner_id'])) {
            $instr = $this->db->query("SELECT stripe_account_id, mp_user_id, payout_share FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id='" . (int)$owner['owner_id'] . "'")->row;
            if ($instr) {
                $dest['stripe'] = $instr['stripe_account_id'] ?? '';
                $dest['mp'] = $instr['mp_user_id'] ?? '';
                $dest['share'] = (float)($owner['payout_share'] ?? $instr['payout_share'] ?? $dest['share']);
            }
        }
        $platform_fee = 100 - $dest['share'];
        // Build split map per item
        $splits = [];
        foreach ($products as $p) {
            $owner = $this->db->query("SELECT owner_id, payout_share FROM `" . DB_PREFIX . "product` WHERE product_id='" . (int)$p['product_id'] . "'")->row;
            $share = (float)($owner['payout_share'] ?? ($this->config->get('payment_platform_fee') ? 100 - (float)$this->config->get('payment_platform_fee') : 80));
            $instr = [];
            if (!empty($owner['owner_id'])) {
                $instr = $this->db->query("SELECT stripe_account_id, mp_user_id, payout_share FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id='" . (int)$owner['owner_id'] . "'")->row;
                if ($instr) {
                    $share = (float)($owner['payout_share'] ?? $instr['payout_share'] ?? $share);
                }
            }
            $line_total = (float)$p['total'];
            $splits[] = [
                'product_id' => (int)$p['product_id'],
                'title' => $p['name'],
                'amount' => $line_total,
                'stripe' => $instr['stripe_account_id'] ?? '',
                'mp' => $instr['mp_user_id'] ?? '',
                'share' => $share
            ];
        }
        $payment_id = $this->model_checkout_payment->create($this->customer->getId(), 'order', $order_id, $method, $price, $order['currency_code'] ?? ($this->config->get('config_currency') ?? 'BRL'), ['splits' => $splits]);
        $success = $this->url->link('checkout/pay_split.success', 'payment_id=' . $payment_id . '&method=' . $method, true);
        $cancel = $this->url->link('checkout/pay_split.checkout', 'order_id=' . $order_id);
        if ($method === 'stripe') {
            $description = 'Pedido #' . $order_id;
            $checkout = $this->model_checkout_gateway->createStripeCheckout($price, $order['currency_code'] ?? ($this->config->get('config_currency') ?? 'BRL'), $description, $success . '&session_id={CHECKOUT_SESSION_ID}', $cancel, '', 0);
            if (!empty($checkout['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($checkout['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($checkout['url'] ?? $cancel);
                return;
            }
        } elseif ($method === 'mercadopago') {
            $title = 'Pedido #' . $order_id;
            $pref = $this->model_checkout_gateway->createMpPreference($price, $order['currency_code'] ?? ($this->config->get('config_currency') ?? 'BRL'), $title, $success . '&preference_id={PREF_ID}', $cancel, $dest['mp'], $platform_fee);
            if (!empty($pref['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($pref['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($pref['init_point'] ?? $cancel);
                return;
            }
        }
        $this->model_checkout_payment->markPaid($payment_id, strtoupper($method) . '-' . $payment_id);
        $this->session->data['success'] = $this->language->get('text_payment_success');
        $this->response->redirect($this->url->link('checkout/success'));
    }

    public function success(): void {
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');
        $payment_id = (int)($this->request->get['payment_id'] ?? 0);
        $method = $this->request->get['method'] ?? '';
        $payment = $this->model_checkout_payment->getPayment($payment_id);
        if (!$payment) {
            $this->response->redirect($this->url->link('checkout/cart'));
            return;
        }
        $ok = false;
        if ($method === 'stripe') {
            $sid = $this->request->get['session_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($sid) $ok = $this->model_checkout_gateway->verifyStripeSession($sid);
        } elseif ($method === 'mercadopago') {
            $pref = $this->request->get['preference_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($pref) $ok = $this->model_checkout_gateway->verifyMpPayment($pref);
        }
        if ($ok) {
            $this->model_checkout_payment->markPaid($payment_id, $payment['transaction_ref'] ?? '');
            $this->load->model('checkout/order');
            $this->model_checkout_order->addOrderHistory((int)$payment['reference_id'], $this->config->get('config_order_status_id') ?? 5, 'Pago via PaySplit', true);
            $this->session->data['success'] = $this->language->get('text_payment_success');
            $this->cart->clear();
            unset($this->session->data['order_id']);
        }
        $this->response->redirect($this->url->link('checkout/success'));
    }
}
