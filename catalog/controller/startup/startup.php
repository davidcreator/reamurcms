<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Startup
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Startup extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		// Load startup actions
		$this->load->model('setting/startup');

		$results = $this->model_setting_startup->getStartups();

		foreach ($results as $result) {
			if (substr($result['action'], 0, 8) == 'catalog/') {
				$this->load->controller(substr($result['action'], 8));
			}
		}
	}
}