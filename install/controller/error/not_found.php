<?php
namespace Reamur\Install\Controller\Error;
/**
 * Class NotFound
 * @package Reamur\Install\Controller\Error
 */
class NotFound extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->load->language('error/not_found');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_error'] = $this->language->get('text_error');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home', 'language=' . $this->config->get('language_code'));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$protocol = $this->request->server['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
		$this->response->addHeader($protocol . ' 404 Not Found');

		$this->response->setOutput($this->load->view('error/not_found', $data));
	}
}
