<?php
namespace Reamur\Catalog\Controller\Cms;

class Landpage extends \Reamur\System\Engine\Controller {
    public function info(): void {
        $this->load->model('cms/landpage');
        $this->load->model('tool/image');

        $slug = $this->request->get['slug'] ?? '';
        $page = $this->model_cms_landpage->getPageBySlug($slug);

        if (!$page) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }

        $data['page'] = $page;
        $data['title'] = $page['title'];

        $metaTitle = $page['meta_title'] ?? '';
        $this->document->setTitle($metaTitle !== '' ? $metaTitle : $page['title']);
        if (!empty($page['meta_description'] ?? '')) {
            $this->document->setDescription($page['meta_description']);
        }
        if (!empty($page['meta_keyword'] ?? '')) {
            $this->document->setKeywords($page['meta_keyword']);
        }

        if (!empty($page['featured_image'] ?? '') && is_file(DIR_IMAGE . $page['featured_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($page['featured_image'], 1200, 630);
        } else {
            $data['thumb'] = null;
        }

        $data['custom_css'] = $page['custom_css'] ?? '';

        $this->response->setOutput($this->load->view('cms/landpage', $data));
    }
}
