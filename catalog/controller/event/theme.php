<?php
namespace Reamur\Catalog\Controller\Event;
/**
 * Class Theme
 *
 * @package Reamur\Catalog\Controller\Event
 */
class Theme extends \Reamur\System\Engine\Controller {
	/**
	 * @param string $route
	 * @param array  $args
	 * @param string $code
	 *
	 * @return void
	 */
	public function index(string &$route, array &$args, string &$code): void {
		// If there is a theme override we should get it
		$this->load->model('design/theme');

		$theme_info = $this->model_design_theme->getTheme($route, $this->config->get('config_theme'));

		if ($theme_info) {
			$code = html_entity_decode($theme_info['code'], ENT_QUOTES, 'UTF-8');
		}
	}
}