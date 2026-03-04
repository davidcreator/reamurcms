<?php
namespace Reamur\Install\Controller\Install;
/**
 * Class Step4
 * @package Reamur\Install\Controller\Install
 */
class Step4 extends \Reamur\System\Engine\Controller {
	/** @return void */
	public function index(): void {
		$this->load->language('install/step_4');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_step_4'] = $this->language->get('text_step_4');
		$data['text_catalog'] = $this->language->get('text_catalog');
		$data['text_admin'] = $this->language->get('text_admin');
		$data['text_extension'] = $this->language->get('text_extension');
		$data['text_install_extensions'] = $this->language->get('text_install_extensions');
		$data['text_install_extensions_desc'] = $this->language->get('text_install_extensions_desc');
		$data['text_blog_title'] = $this->language->get('text_blog_title');
		$data['text_blog_desc'] = $this->language->get('text_blog_desc');
		$data['text_landpage_title'] = $this->language->get('text_landpage_title');
		$data['text_landpage_desc'] = $this->language->get('text_landpage_desc');
		$data['text_mooc_title'] = $this->language->get('text_mooc_title');
		$data['text_mooc_desc'] = $this->language->get('text_mooc_desc');
		$data['text_installing'] = $this->language->get('text_installing');
		$data['text_installed'] = $this->language->get('text_installed');
		$data['text_install_error'] = $this->language->get('text_install_error');

		$data['text_mail'] = $this->language->get('text_mail');
		$data['text_mail_description'] = $this->language->get('text_mail_description');

		$data['text_facebook'] = $this->language->get('text_facebook');
		$data['text_facebook_description'] = $this->language->get('text_facebook_description');
		$data['text_facebook_visit'] = $this->language->get('text_facebook_visit');

		$data['text_forum'] = $this->language->get('text_forum');
		$data['text_forum_description'] = $this->language->get('text_forum_description');
		$data['text_forum_visit'] = $this->language->get('text_forum_visit');

		$data['text_commercial'] = $this->language->get('text_commercial');
		$data['text_commercial_description'] = $this->language->get('text_commercial_description');
		$data['text_commercial_visit'] = $this->language->get('text_commercial_visit');

		$data['button_mail'] = $this->language->get('button_mail');
		$data['button_install_now'] = $this->language->get('button_install_now');

		$data['error_warning'] = $this->language->get('error_warning');
		$data['success_message'] = '';
		$data['status_blog'] = '';
		$data['status_landpage'] = '';
		$data['status_mooc'] = '';

		// Instalação inline das extensões (POST)
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['install_extension'])) {
			$which = $this->request->post['install_extension'];
			try {
				$dbData = $this->getDbCredentials();

				$message = '';

				switch ($which) {
					case 'blog':
						$this->load->model('extensions/blog_install');
						$count = $this->model_extensions_blog_install->install($dbData);
						$message = sprintf($this->language->get('text_installed'), (int)$count);
						$data['status_blog'] = $message;
						break;
					case 'landpage':
						$this->load->model('extensions/landpage_install');
						$count = $this->model_extensions_landpage_install->install($dbData);
						$message = sprintf($this->language->get('text_installed'), (int)$count);
						$data['status_landpage'] = $message;
						break;
					case 'mooc':
						$this->load->model('extensions/mooc_install');
						$count = $this->model_extensions_mooc_install->install($dbData);
						$message = sprintf($this->language->get('text_installed'), (int)$count);
						$data['status_mooc'] = $message;
						break;
					default:
						throw new \RuntimeException('Extension not supported.');
				}

				$data['success_message'] = $message;
			} catch (\Throwable $e) {
				$data['error_warning'] = sprintf($this->language->get('text_install_error'), $e->getMessage());
				if ($which === 'blog') {
					$data['status_blog'] = $data['error_warning'];
				} elseif ($which === 'landpage') {
					$data['status_landpage'] = $data['error_warning'];
				} else {
					$data['status_mooc'] = $data['error_warning'];
				}
			}
		}

		$data['promotion'] = $this->load->controller('install/promotion');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('install/step_4', $data));
	}

	/**
	 * Lê as credenciais de banco do config.php gerado no passo 3.
	 *
	 * @return array
	 */
	private function getDbCredentials(): array {
		$configFile = DIR_REAMUR . 'config.php';

		if (!is_file($configFile)) {
			throw new \RuntimeException('config.php não encontrado. Conclua a instalação básica primeiro.');
		}

		$content = file_get_contents($configFile);
		if ($content === false) {
			throw new \RuntimeException('Não foi possível ler config.php');
		}

		$map = [];
		$patterns = [
			'db_driver'   => 'DB_DRIVER',
			'db_hostname' => 'DB_HOSTNAME',
			'db_username' => 'DB_USERNAME',
			'db_password' => 'DB_PASSWORD',
			'db_database' => 'DB_DATABASE',
			'db_port'     => 'DB_PORT',
			'db_prefix'   => 'DB_PREFIX',
		];

		foreach ($patterns as $key => $const) {
			if (preg_match("/define\\('\\Q{$const}\\E',\\s*['\"]([^'\"]*)['\"]\\);/i", $content, $match)) {
				$map[$key] = stripcslashes($match[1]);
			}
		}

		foreach (['db_driver', 'db_hostname', 'db_username', 'db_database'] as $required) {
			if (empty($map[$required])) {
				throw new \RuntimeException('Parâmetro ausente em config.php: ' . $required);
			}
		}

		$map['db_password'] = $map['db_password'] ?? '';
		$map['db_port'] = $map['db_port'] ?? '3306';
		$map['db_prefix'] = $map['db_prefix'] ?? 'rms_';

		return $map;
	}
}
