<?php
namespace Reamur\Admin\Controller\Common;
/**
 * Class Logout
 *
 * @package Reamur\Admin\Controller\Common
 */
class Logout extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->user->logout();

		unset($this->session->data['user_token']);

		$this->response->redirect($this->url->link('common/login', '', true));
	}
}