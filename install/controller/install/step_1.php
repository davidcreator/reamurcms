<?php
namespace Reamur\Install\Controller\Install;

/**
 * Class Step1
 * @package Reamur\Install\Controller\Install
 */
class Step1 extends \Reamur\System\Engine\Controller {
    /** @return void */
    public function index(): void {
        $this->load->language('install/step_1');

        // Definir título do documento
        $this->document->setTitle($this->language->get('heading_title'));

        // Configurar variáveis para o template
        $data = [
            'heading_title'   => $this->language->get('heading_title'),
            'text_step_1'     => $this->language->get('text_step_1'),
            'text_terms'      => $this->language->get('text_terms'),
            'button_continue' => $this->language->get('button_continue'),
        ];

        // Verificar se o idioma foi selecionado na URL e atualizar a configuração
        if (isset($this->request->get['language'])) {
            $this->session->data['language'] = $this->request->get['language'];
            $this->config->set('language_code', $this->request->get['language']);
        }

        // Garantir que o idioma correto seja utilizado na próxima etapa
        $data['continue'] = $this->url->link('install/step_2', 'language=' . ($this->session->data['language'] ?? $this->config->get('language_code')));

        // Carregar cabeçalho, rodapé e seletor de idioma
        $data['footer']   = $this->load->controller('common/footer');
        $data['header']   = $this->load->controller('common/header');
        $data['language'] = $this->load->controller('common/language');

        // Renderizar a saída
        $this->response->setOutput($this->load->view('install/step_1', $data));
    }
}