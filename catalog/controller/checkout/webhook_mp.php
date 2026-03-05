<?php
namespace Reamur\Catalog\Controller\Checkout;

class WebhookMp extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->model('checkout/payment');
        $pref = $this->request->get['preference_id'] ?? ($this->request->post['preference_id'] ?? '');
        if ($pref) {
            $payment = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payment` WHERE transaction_ref='" . $this->db->escape($pref) . "'")->row;
            if ($payment) {
                $this->model_checkout_payment->markPaid((int)$payment['payment_id'], $pref);
                if ($payment['context'] === 'order') {
                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory((int)$payment['reference_id'], $this->config->get('config_order_status_id') ?? 5, 'Pago via Mercado Pago', true);
                }
            }
        }
        $this->response->addHeader('HTTP/1.1 200 OK');
        $this->response->setOutput('ok');
    }
}
