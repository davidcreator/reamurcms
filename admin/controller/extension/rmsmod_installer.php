<?php
namespace Reamur\Admin\Controller\Extension;

class RmsmodInstaller extends \Reamur\System\Engine\Controller {
	private array $error = [];

	public function index(): void {
		$this->load->language('extension/rmsmod_installer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->ensureAdminPermission();

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_description'] = $this->language->get('text_description');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_back'] = $this->language->get('button_back');

		$data['success'] = $this->session->data['success'] ?? '';
		$data['error_warning'] = $this->error['warning'] ?? '';
		unset($this->session->data['success']);

		$data['modules'] = [
			'blog' => [
				'code' => 'blog',
				'name' => 'Blog',
				'desc' => $this->language->get('text_blog_desc'),
			],
			'landpage' => [
				'code' => 'landpage',
				'name' => 'Landing Pages',
				'desc' => $this->language->get('text_landpage_desc'),
			],
			'mooc' => [
				'code' => 'mooc',
				'name' => 'MOOC',
				'desc' => $this->language->get('text_mooc_desc'),
			],
		];

		if ($this->request->server['REQUEST_METHOD'] === 'POST') {
			$this->install($data['modules']);
			return;
		}

		$data['user_token'] = $this->session->data['user_token'];
		$data['action'] = $this->url->link('extension/rmsmod_installer', 'user_token=' . $data['user_token']);
		$data['back'] = $this->url->link('common/dashboard', 'user_token=' . $data['user_token']);

		$data['breadcrumbs'] = [
			[
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
			],
			[
				'text' => $this->language->get('heading_title'),
				'href' => $data['action']
			],
		];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/rmsmod_installer', $data));
	}

	private function install(array $modules): void {
		if (!$this->user->hasPermission('modify', 'extension/rmsmod_installer')) {
			$this->error['warning'] = $this->language->get('error_permission');
			return;
		}

		$selected = $this->request->post['modules'] ?? [];
		if (!is_array($selected) || !$selected) {
			$this->error['warning'] = $this->language->get('error_selection');
			return;
		}

		$extMap = [
			'blog'     => DIR_REAMUR . 'install/model/extensions/blog_install.php',
			'landpage' => DIR_REAMUR . 'install/model/extensions/landpage_install.php',
			'mooc'     => DIR_REAMUR . 'install/model/extensions/mooc_install.php',
		];

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
			if (!isset($extMap[$code])) {
				continue;
			}
			$path = $extMap[$code];
			if (!is_file($path)) {
				continue;
			}
			require_once $path;
			$class = '\\Reamur\\Install\\Model\\Extensions\\' . ucfirst($code) . 'Install';
			if (class_exists($class)) {
				$installer = new $class($this->registry);
				$installer->install($dbData);
				$installed[] = $code;
			}
		}

		if ($installed) {
			$this->session->data['success'] = sprintf($this->language->get('text_installed'), implode(', ', $installed));
			$this->response->redirect($this->url->link('extension/rmsmod_installer', 'user_token=' . $this->session->data['user_token']));
		} else {
			$this->error['warning'] = $this->language->get('error_none');
		}
	}

	/**
	 * Guarantee Administrator can access this tool
	 */
	private function ensureAdminPermission(): void {
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/rmsmod_installer');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/rmsmod_installer');
	}
}
