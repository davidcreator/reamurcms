<?php
namespace Reamur\Catalog\Controller\Extension\OcThemeExample\Startup;
class ThemeExample extends \Reamur\System\Engine\Controller {
	public function index(): void {
		if ($this->config->get('config_theme') == 'theme_example' && $this->config->get('theme_theme_example_status')) {
			// Add event via code instead of DB
			// Could also just set view/common/header/before
			$this->event->register('view/*/before', new \Reamur\System\Engine\Action('extension/rms_theme_example/startup/theme_example.event'));
		}
	}

	public function event(string &$route, array &$args, mixed &$output): void {
		$override = ['common/header'];

		if (in_array($route, $override)) {
			$route = 'extension/rms_theme_example/' . $route;
		}
	}
}