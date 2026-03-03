<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Customer
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Customer extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->registry->set('customer', new \Reamur\System\Library\Cart\Customer($this->registry));

		// Customer Group
		if (isset($this->session->data['customer'])) {
			$this->config->set('config_customer_group_id', $this->session->data['customer']['customer_group_id']);
		} elseif ($this->customer->isLogged()) {
			// Logged in customers
			$this->config->set('config_customer_group_id', $this->customer->getGroupId());
		}
	}
}