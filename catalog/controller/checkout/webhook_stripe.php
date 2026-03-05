<?php
namespace Reamur\Catalog\Controller\Checkout;

class WebhookStripe extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);
        $session = $data['data']['object'] ?? [];
        $session_id = $session['id'] ?? '';
        $charge_id = '';
        if (($data['type'] ?? '') === 'checkout.session.completed' && $session_id) {
            if (empty($charge_id) && !empty($session['payment_intent'])) {
                $pi = $this->model_checkout_gateway->getStripePaymentIntent($session['payment_intent']);
                $charge_id = $pi['latest_charge'] ?? ($pi['charges']['data'][0]['id'] ?? '');
            }
            $payment = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payment` WHERE transaction_ref='" . $this->db->escape($session_id) . "'")->row;
            if ($payment) {
                $this->model_checkout_payment->markPaid((int)$payment['payment_id'], $session_id);
                if ($payment['context'] === 'order') {
                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory((int)$payment['reference_id'], $this->config->get('config_order_status_id') ?? 5, 'Pago via Stripe', true);
                    // Handle split transfers
                    if (!empty($payment['meta'])) {
                        $meta = json_decode($payment['meta'], true);
                        $splits = $meta['splits'] ?? [];
                        $secret = getenv('STRIPE_SECRET') ?: $this->config->get('payment_stripe_secret');
                        $source_txn = $charge_id ?: $session_id;
                        foreach ($splits as $split) {
                            if (!empty($split['stripe'])) {
                                $amount_cents = (int)round(((float)$split['amount']) * ($split['share'] / 100) * 100);
                                if ($amount_cents > 0) {
                                    $this->model_checkout_gateway->stripeTransfer($secret, $split['stripe'], $amount_cents, $payment['currency'] ?? 'BRL', $source_txn, 'Order ' . $payment['reference_id'] . ' - ' . $split['title']);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->response->addHeader('HTTP/1.1 200 OK');
        $this->response->setOutput('ok');
    }
}
