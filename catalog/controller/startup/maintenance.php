<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Maintenance
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Maintenance extends \Reamur\System\Engine\Controller {
	/**
	 * @return object|\Reamur\System\Engine\Action|null
	 */
	public function index(): object|null {
		if ($this->config->get('config_maintenance')) {
			// Route
			if (isset($this->request->get['route'])) {
				$route = $this->request->get['route'];
			} else {
				$route = $this->config->get('action_default');
			}

			$ignore = [
				'common/language/language',
				'common/currency/currency'
			];

			// Show site if logged in as admin
			$user = new \Reamur\System\Library\Cart\User($this->registry);

			if (substr($route, 0, 3) != 'api' && !in_array($route, $ignore) && !$user->isLogged()) {
				return new \Reamur\System\Engine\Action('common/maintenance');
			}
		}

		return null;
	}
}
