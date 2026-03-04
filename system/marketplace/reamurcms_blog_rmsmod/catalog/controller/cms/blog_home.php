<?php
namespace Reamur\Catalog\Controller\Cms;

class Blog_Home extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $this->load->model('cms/category');

        $languageParam = 'language=' . $this->config->get('config_language');

        // Data sources
        $featured = $this->model_cms_blog->getPosts(['status' => 'published', 'is_featured' => true, 'limit' => 4]);
        $latest = $this->model_cms_blog->getLatestPosts(6);
        $top = $this->model_cms_blog->getTopPosts(5);
        $categories = $this->model_cms_category->getCategories();
        $tags = $this->model_cms_blog->getTags(30);

        // Normalize links
        foreach ($featured as &$p) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
            $p['tags_list'] = $p['tags'] ? array_map('trim', explode(',', $p['tags'])) : [];
        }
        foreach ($latest as &$p) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
        }
        foreach ($top as &$p) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
        }
        foreach ($categories as &$cat) {
            $cat['href'] = $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($cat['slug']));
        }
        foreach ($tags as &$tag) {
            $tag['href'] = $this->url->link('cms/tag', $languageParam . '&tag=' . urlencode($tag['slug'] ?: $tag['name']));
        }

        $data = [];
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_featured_posts'] = $this->language->get('text_featured_posts');
        $data['text_latest_posts'] = $this->language->get('text_latest_posts');
        $data['text_top_posts'] = $this->language->get('text_top_posts');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_tags'] = $this->language->get('text_tags');
        $data['text_read_more'] = $this->language->get('text_read_more');
        $data['text_read_time'] = $this->language->get('text_read_time');
        $data['text_minutes'] = $this->language->get('text_minutes');
        $data['text_published_on'] = $this->language->get('text_published_on');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['entry_search'] = $this->language->get('entry_search');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['text_filters_reset'] = $this->language->get('text_filters_reset');
        $data['link_blog'] = $this->url->link('cms/blog', $languageParam);
        $data['link_tag_base'] = $this->url->link('cms/tag', $languageParam);
        $data['link_category_base'] = $this->url->link('cms/category', $languageParam);

        $data['featured_posts'] = $featured;
        $data['latest_posts'] = $latest;
        $data['top_posts'] = $top;
        $data['categories'] = $categories;
        $data['tags'] = $tags;

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', $languageParam)
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/blog', $languageParam)
            ]
        ];

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addLink($this->url->link('cms/blog_home', $languageParam, true), 'canonical');
        $this->document->addScript('catalog/view/js/blog-interact.js', 'footer');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('cms/blog_home', $data));
    }
}
