<?php
namespace Reamur\Catalog\Controller\Cms;

class Landpage extends \Reamur\System\Engine\Controller {
    public function index(): void {
        if (!class_exists('\\Pagination')) {
            require_once(DIR_SYSTEM . 'library/pagination.php');
        }

        $this->load->language('cms/landpage');
        $this->document->setTitle($this->language->get('heading_title_list'));

        $page = max(1, (int)($this->request->get['page'] ?? 1));
        $limit = 12;
        $start = ($page - 1) * $limit;

        $this->load->model('cms/landpage');
        $this->load->model('tool/image');

        $total = $this->model_cms_landpage->getTotalPages();
        $pages = $this->model_cms_landpage->getPages(['start' => $start, 'limit' => $limit]);

        $data['pages'] = [];
        foreach ($pages as $p) {
            $thumb = '';
            if (!empty($p['featured_image']) && is_file(DIR_IMAGE . $p['featured_image'])) {
                $thumb = $this->model_tool_image->resize($p['featured_image'], 800, 450);
            }
            $excerpt = $p['meta_description'] ?? '';
            if ($excerpt === '') {
                $excerpt = $this->trimHtmlToExcerpt($this->model_cms_landpage->getPageBySlug($p['slug'])['html'] ?? '');
            }

            $data['pages'][] = [
                'title'         => $p['title'],
                'slug'          => $p['slug'],
                'href'          => $this->url->link('cms/landpage.info', 'language=' . $this->config->get('config_language') . '&slug=' . $p['slug']),
                'published_at'  => $p['published_at'],
                'thumb'         => $thumb,
                'excerpt'       => $excerpt
            ];
        }

        // Pagination
        $pagination = new \Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('cms/landpage', 'language=' . $this->config->get('config_language') . '&page={page}');
        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? $start + 1 : 0, ($start > ($total - $limit)) ? $total : ($start + $limit), $total, ceil($total / $limit));

        $data['heading_title'] = $this->language->get('heading_title_list');
        $data['text_tagline'] = $this->language->get('text_tagline');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['button_view'] = $this->language->get('button_view');

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
            ],
            [
                'text' => $data['heading_title'],
                'href' => $this->url->link('cms/landpage', 'language=' . $this->config->get('config_language'))
            ]
        ];

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('cms/landpage_list', $data));
    }

    public function info(): void {
        $this->load->language('cms/landpage');
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
        $data['home'] = $this->url->link('common/home', 'language=' . $this->config->get('config_language'));
        $data['list_href'] = $this->url->link('cms/landpage', 'language=' . $this->config->get('config_language'));
        $data['heading_title_list'] = $this->language->get('heading_title_list');
        $data['button_back'] = $this->language->get('button_back') ?? $this->language->get('text_home');
        $data['text_home'] = $this->language->get('text_home');

        $this->response->setOutput($this->load->view('cms/landpage', $data));
    }

    private function trimHtmlToExcerpt(string $html, int $length = 180): string {
        $text = trim(strip_tags($html));
        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length - 3) . '...';
        }
        return $text;
    }
}
