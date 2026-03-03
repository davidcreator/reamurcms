<?php
namespace Reamur\Catalog\Controller\Cms;

class Landpage extends \Reamur\System\Engine\Controller {
    public function info(): void {
        $this->load->model('cms/landpage');

        $slug = $this->request->get['slug'] ?? '';
        $page = $this->model_cms_landpage->getPageBySlug($slug);

        if (!$page) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }

        $data['page'] = $page;
        $data['title'] = $page['title'];

        $this->response->setOutput($this->load->view('cms/landpage', $data));
    }
}
