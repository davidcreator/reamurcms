<?php
namespace Reamur\Install\Controller\Upgrade;

class Upgrade extends \Reamur\System\Engine\Controller {
	public function index(): void {
		$this->load->language('upgrade/upgrade');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_upgrade'] = $this->language->get('text_upgrade');
		$data['text_extensions'] = $this->language->get('text_extensions');
		$data['text_extensions_desc'] = $this->language->get('text_extensions_desc');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['language'] = $this->load->controller('common/language');

		$data['success'] = $this->session->data['success'] ?? '';
		unset($this->session->data['success']);
		$data['error_warning'] = $this->session->data['error_warning'] ?? '';
		unset($this->session->data['error_warning']);

		$data['modules'] = [
			'blog' => ['code' => 'blog', 'name' => 'Blog'],
			'landpage' => ['code' => 'landpage', 'name' => 'Landing Pages'],
			'mooc' => ['code' => 'mooc', 'name' => 'MOOC']
		];

		$data['action'] = $this->url->link('upgrade/upgrade');
		$data['admin_link'] = HTTP_REAMUR . 'admin/';

		if ($this->request->server['REQUEST_METHOD'] === 'POST') {
			$this->runExtensions($data['modules']);
			$this->response->redirect($data['action']);
			return;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('upgrade/upgrade', $data));
	}

	private function runExtensions(array $modules): void {
		$selected = $this->request->post['modules'] ?? [];
		if (!$selected) {
			$this->session->data['error_warning'] = $this->language->get('error_selection');
			return;
		}

		$map = [
			'blog'     => DIR_REAMUR . 'install/model/extensions/blog_install.php',
			'landpage' => DIR_REAMUR . 'install/model/extensions/landpage_install.php',
			'mooc'     => DIR_REAMUR . 'install/model/extensions/mooc_install.php',
		];

		require_once(DIR_REAMUR . 'config.php');

		$dbData = [
			'db_driver'   => DB_DRIVER,
			'db_hostname' => DB_HOSTNAME,
			'db_username' => DB_USERNAME,
			'db_password' => DB_PASSWORD,
			'db_database' => DB_DATABASE,
			'db_port'     => DB_PORT,
			'db_prefix'   => DB_PREFIX,
		];

		$installed = [];

		foreach ($selected as $code) {
			if (!isset($map[$code]) || !is_file($map[$code])) {
				continue;
			}

			require_once $map[$code];
			$class = '\\Reamur\\Install\\Model\\Extensions\\' . ucfirst($code) . 'Install';

			if (class_exists($class)) {
				$installer = new $class($this->registry);
				$installer->install($dbData);
				$installed[] = $code;
			}
		}

		if ($installed) {
			$this->session->data['success'] = sprintf($this->language->get('text_installed'), implode(', ', $installed));
		} else {
			$this->session->data['error_warning'] = $this->language->get('error_none');
		}
	}
}
