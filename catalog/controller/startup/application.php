<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Application
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Application extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		// Weight
		$this->registry->set('weight', new \Reamur\System\Library\Cart\Weight($this->registry));

		// Length
		$this->registry->set('length', new \Reamur\System\Library\Cart\Length($this->registry));

		// Cart
		$this->registry->set('cart', new \Reamur\System\Library\Cart\Cart($this->registry));
	}
}