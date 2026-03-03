<?php
namespace Reamur\Catalog\Model\Extension\Reamur\Total;
/**
 * Class Total
 *
 * @package
 */
class Total extends \Reamur\System\Engine\Model {
	/**
	 * @param array $totals
	 * @param array $taxes
	 * @param float $total
	 *
	 * @return void
	 */
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