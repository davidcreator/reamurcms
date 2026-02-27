<?php
namespace Reamur\Front\Controller\Extension\Reamur\Payment;
class Cod extends \Reamur\System\Engine\Controller {
	public function index(): string {
		$this->load->language('extension/reamur/payment/cod');

		$data['language'] = $this->config->get('config_language');

		return $this->load->view('extension/reamur/payment/cod', $data);
	}

	public function confirm(): void {
		$this->load->language('extension/reamur/payment/cod');

		$json = [];

		if (!isset($this->session->data['order_id'])) {
			$json['error'] = $this->language->get('error_order');
		}

		if (!isset($this->session->data['payment_method']) || $this->session->data['payment_method']['code'] != 'cod.cod') {
			$json['error'] = $this->language->get('error_payment_method');
		}

		if (!$json) {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addHistory($this->session->data['order_id'], $this->config->get('payment_cod_order_status_id'));

			$json['redirect'] = $this->url->link('checkout/success', 'language=' . $this->config->get('config_language'), true);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
