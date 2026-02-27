<?php
namespace Reamur\Front\Model\Extension\Reamur\Total;
class Total extends \Reamur\System\Engine\Model {
	public function getTotal(array &$totals, array &$taxes, float &$total): void {
		$this->load->language('extension/reamur/total/total');

		$totals[] = [
			'extension'  => 'reamur',
			'code'       => 'total',
			'title'      => $this->language->get('text_total'),
			'value'      => $total,
			'sort_order' => (int)$this->config->get('total_total_sort_order')
		];
	}
}