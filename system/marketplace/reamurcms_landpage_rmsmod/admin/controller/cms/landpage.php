<?php
namespace Reamur\Admin\Controller\Cms;

class Landpage extends \Reamur\System\Engine\Controller {
    private array $error = [];

    public function index(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_title'] = $this->language->get('column_title');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date'] = $this->language->get('column_date');
        $data['column_action'] = $this->language->get('column_action');

        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $raw_pages = $this->model_cms_landpage->getPages(['start' => $start, 'limit' => $limit]);
        $data['pages'] = array_map(function ($page) use ($data) {
            $page['edit'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token'] . '&page_id=' . $page['page_id']);
            return $page;
        }, $raw_pages);
        $data['total'] = $this->model_cms_landpage->getTotalPages();
        $data['page'] = $page;
        $data['success'] = $this->session->data['success'] ?? '';
        unset($this->session->data['success']);

        $data['user_token'] = $this->session->data['user_token'];
        $data['add'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token']);
        $data['delete'] = $this->url->link('cms/landpage.delete', 'user_token=' . $data['user_token']);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/landpage', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_list', $data));
    }

    public function form(): void {
        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('cms/landpage');
        $this->model_cms_landpage->ensureTables();
        $this->load->model('tool/image');

        $this->document->addScript('view/js/ckeditor/ckeditor.js');
        $this->document->addScript('view/js/ckeditor/adapters/jquery.js');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = $this->language->get('text_form');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_clear'] = $this->language->get('button_clear');
        $data['button_insert_snippet'] = $this->language->get('button_insert_snippet');
        $data['text_draft'] = $this->language->get('text_draft');
        $data['text_published'] = $this->language->get('text_published');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_slug'] = $this->language->get('entry_slug');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_html'] = $this->language->get('entry_html');
        $data['entry_template'] = $this->language->get('entry_template');
        $data['entry_featured_image'] = $this->language->get('entry_featured_image');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_published_at'] = $this->language->get('entry_published_at');
        $data['entry_custom_css'] = $this->language->get('entry_custom_css');
        $data['text_snippet'] = $this->language->get('text_snippet');
        $data['text_snippet_help'] = $this->language->get('text_snippet_help');
        $data['text_template_default'] = $this->language->get('text_template_default');
        $data['text_template_hero'] = $this->language->get('text_template_hero');
        $data['text_template_split'] = $this->language->get('text_template_split');
        $data['text_template_lead'] = $this->language->get('text_template_lead');
        $data['ckeditor'] = $this->config->get('config_language');

        $data['snippets'] = [
            'hero' => '<section class=\"py-5 bg-primary text-white\"><div class=\"container\"><div class=\"row align-items-center\"><div class=\"col-md-6\"><h1>Seu título chamativo</h1><p class=\"lead\">Explique o valor da oferta em poucas frases claras.</p><a href=\"#cta\" class=\"btn btn-light btn-lg\">Chamada para ação</a></div><div class=\"col-md-6 text-center\"><img src=\"https://via.placeholder.com/480x320\" class=\"img-fluid rounded\" alt=\"\"></div></div></div></section>',
            'features' => '<section class=\"py-5\"><div class=\"container\"><div class=\"row text-center mb-4\"><div class=\"col\"><h2>Recursos principais</h2><p class=\"text-muted\">Liste benefícios e provas.</p></div></div><div class=\"row g-4\"><div class=\"col-md-4\"><div class=\"card h-100 shadow-sm\"><div class=\"card-body\"><h4>Recurso 1</h4><p>Descreva o benefício.</p></div></div></div><div class=\"col-md-4\"><div class=\"card h-100 shadow-sm\"><div class=\"card-body\"><h4>Recurso 2</h4><p>Descreva o benefício.</p></div></div></div><div class=\"col-md-4\"><div class=\"card h-100 shadow-sm\"><div class=\"card-body\"><h4>Recurso 3</h4><p>Descreva o benefício.</p></div></div></div></div></div></section>',
            'cta' => '<section id=\"cta\" class=\"py-5 bg-dark text-white text-center\"><div class=\"container\"><h2>Pronto para começar?</h2><p class=\"lead\">Coloque uma frase curta de persuasão.</p><a href=\"#form\" class=\"btn btn-primary btn-lg\">Quero avançar</a></div></section>',
            'form' => '<section id=\"form\" class=\"py-5\"><div class=\"container\"><div class=\"row justify-content-center\"><div class=\"col-md-8\"><div class=\"card shadow-sm\"><div class=\"card-body\"><h3 class=\"mb-3\">Cadastre-se</h3><form><div class=\"mb-3\"><label class=\"form-label\">Nome</label><input type=\"text\" class=\"form-control\" placeholder=\"Seu nome\"></div><div class=\"mb-3\"><label class=\"form-label\">E-mail</label><input type=\"email\" class=\"form-control\" placeholder=\"email@exemplo.com\"></div><div class=\"mb-3\"><label class=\"form-label\">Mensagem</label><textarea class=\"form-control\" rows=\"3\"></textarea></div><button class=\"btn btn-primary\" type=\"submit\">Enviar</button></form></div></div></div></div></div></section>'
        ];

        $page_id = (int)($this->request->get['page_id'] ?? 0);

        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validateForm()) {
            $payload = $this->request->post;
            $payload['author_id'] = $this->user->getId() ?? 0;
            if (!empty($payload['published_at'])) {
                $payload['published_at'] = str_replace('T', ' ', $payload['published_at']);
            }

            if ($page_id) {
                $this->model_cms_landpage->edit($page_id, $payload);
            } else {
                $page_id = $this->model_cms_landpage->add($payload);
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('cms/landpage', 'user_token=' . $this->session->data['user_token']));
            return;
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['action'] = $this->url->link('cms/landpage.form', 'user_token=' . $data['user_token'] . ($page_id ? '&page_id=' . $page_id : ''));
        $data['cancel'] = $this->url->link('cms/landpage', 'user_token=' . $data['user_token']);
        $data['errors'] = $this->error;

        if ($page_id && $this->request->server['REQUEST_METHOD'] !== 'POST') {
            $data['page'] = $this->model_cms_landpage->getPage($page_id);
        } else {
            $data['page'] = $this->request->post ?? [
                'title' => '',
                'slug' => '',
                'status' => 'draft',
                'template' => 'default',
                'html' => '',
                'published_at' => '',
                'featured_image' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keyword' => '',
                'custom_css' => ''
            ];
        }

        if (!empty($data['page']['published_at'])) {
            $data['page']['published_at'] = date('Y-m-d\\TH:i', strtotime($data['page']['published_at']));
        }

        $image = $data['page']['featured_image'] ?? '';
        if ($image && is_file(DIR_IMAGE . $image)) {
            $data['thumb'] = $this->model_tool_image->resize($image, 200, 200);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 200, 200);
            $data['page']['featured_image'] = '';
        }
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 200, 200);

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $data['user_token'])
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/landpage', 'user_token=' . $data['user_token'])
            ]
        ];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('cms/landpage_form', $data));
    }

    public function delete(): void {
        $this->load->language('cms/landpage');
        $this->load->model('cms/landpage');
        $ids = $this->request->post['selected'] ?? [];
        foreach ($ids as $id) {
            $this->model_cms_landpage->delete((int)$id);
        }
        $this->response->redirect($this->url->link('cms/landpage', 'user_token=' . $this->session->data['user_token']));
    }

    private function validateForm(): bool {
        if (!$this->user->hasPermission('modify', 'cms/landpage')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (empty($this->request->post['title'])) {
            $this->error['title'] = $this->language->get('error_title');
        }
        if (empty($this->request->post['slug'])) {
            $this->request->post['slug'] = $this->slugify($this->request->post['title'] ?? '');
        }
        return !$this->error;
    }

    private function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        return trim($text, '-');
    }
}
