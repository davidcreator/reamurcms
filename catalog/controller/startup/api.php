<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Api
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Api extends \Reamur\System\Engine\Controller {
	/**
	 * @return object|\Reamur\System\Engine\Action|null
	 */
	public function index(): object|null {
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = '';
		}

		if (substr($route, 0, 4) == 'api/' && $route !== 'api/account/login' && !isset($this->session->data['api_id'])) {
			return new \Reamur\System\Engine\Action('error/permission');
		}

		return null;
	}
}
