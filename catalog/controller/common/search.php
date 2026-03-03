<?php
namespace Reamur\Catalog\Controller\Common;
/**
 * Class Search
 *
 * @package Reamur\Catalog\Controller\Common
 */
class Search extends \Reamur\System\Engine\Controller {
	/**
	 * @return string
	 */
	public function index(): string {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		$data['language'] = $this->config->get('config_language');

		return $this->load->view('common/search', $data);
	}
}