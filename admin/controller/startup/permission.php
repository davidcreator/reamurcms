<?php
namespace Reamur\Admin\Controller\Startup;
/**
 * Class Permission
 *
 * @package Reamur\Admin\Controller\Startup
 */
class Permission extends \Reamur\System\Engine\Controller {
	/**
	 * @return object|\Reamur\System\Engine\Action|null
	 */
	public function index(): object|null {
		if (isset($this->request->get['route'])) {
			$pos = strrpos($this->request->get['route'], '.');

			if ($pos === false) {
				$route = $this->request->get['route'];
			} else {
				$route = substr($this->request->get['route'], 0, $pos);
			}

			// We want to ignore some pages from having its permission checked.
			$ignore = [
				'common/dashboard',
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/authorize',
				'common/language',
				'error/not_found',
				'error/permission'
			];

			if (!in_array($route, $ignore)) {
				// allow any blog sub-route if user can access blog_post
				if (strpos($route, 'cms/blog_') === 0 && $this->user->hasPermission('access', 'cms/blog_post')) {
					return null;
				}
				if (strpos($route, 'cms/landpage') === 0 && ($this->user->hasPermission('access', 'cms/landpage') || $this->user->hasPermission('access', 'cms/blog_post'))) {
					return null;
				}

				if (!$this->user->hasPermission('access', $route)) {
					return new \Reamur\System\Engine\Action('error/permission');
				}
			}
		}

		return null;
	}
}
