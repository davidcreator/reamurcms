<?php
namespace Reamur\Catalog\Controller\Startup;
/**
 * Class Language
 *
 * @package Reamur\Catalog\Controller\Startup
 */
class Language extends \Reamur\System\Engine\Controller {
	/**
	 * @var array
	 */
	private static array $languages = [];

	/**
	 * @return void
	 */
	public function index(): void {
		// Check if language is specified in the URL
		if (isset($this->request->get['language'])) {
			$code = (string)$this->request->get['language'];
			
			// Set language cookie when specified in URL
			$option = [
				'expires'  => time() + 60 * 60 * 24 * 365,
				'path'     => $this->config->get('session_path'),
				'SameSite' => $this->config->get('config_session_samesite')
			];
			
			setcookie('language', $code, $option);
		} else {
			$code = $this->config->get('config_language');
		}

		$this->load->model('localisation/language');

		self::$languages = $this->model_localisation_language->getLanguages();

		if (isset(self::$languages[$code])) {
			$language_info = self::$languages[$code];

			// If extension switch add language directory
			if ($language_info['extension']) {
				$this->language->addPath('extension/' . $language_info['extension'], DIR_EXTENSION . $language_info['extension'] . '/catalog/language/');
			}

			// Set the config language_id key
			$this->config->set('config_language_id', $language_info['language_id']);
			$this->config->set('config_language', $language_info['code']);

			$this->load->language('default');
		}
	}
	
	// Override the language default values

	/**
	 * @param $route
	 * @param $prefix
	 * @param $code
	 * @param $output
	 *
	 * @return void
	 */
	public function after(&$route, &$prefix, &$code, &$output): void {
		if (!$code) {
			$code = $this->config->get('config_language');
		}

		// Use $this->language->load so it's not triggering infinite loops
		$this->language->load($route, $prefix, $code);

		if (isset(self::$languages[$code])) {
			$language_info = self::$languages[$code];

			$path = '';

			if ($language_info['extension']) {
				$extension = 'extension/' . $language_info['extension'];

				if (rms_substr($route, 0, strlen($extension)) != $extension) {
					$path = $extension . '/';
				}
			}

			// Use $this->language->load so it's not triggering infinite loops
			$this->language->load($path . $route, $prefix, $code);
		}
	}
}
