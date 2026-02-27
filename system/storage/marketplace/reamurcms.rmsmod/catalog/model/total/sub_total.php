<?php
namespace Reamur\Front\Model\Extension\Reamur\Total;
class SubTotal extends \Reamur\System\Engine\Model {
	public function getTotal(array &$totals, array &$taxes, float &$total): void {
		$this->load->language('extension/reamur/total/sub_total');

		$sub_total = $this->cart->getSubTotal();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$sub_total += $voucher['amount'];
			}
		}

		$totals[] = [
			'extension'  => 'reamur',
			'code'       => 'sub_total',
			'title'      => $this->language->get('text_sub_total'),
			'value'      => $sub_total,
			'sort_order' => (int)$this->config->get('total_sub_total_sort_order')
		];

		$total += $sub_total;
	}
}