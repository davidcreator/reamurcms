<?php
namespace Reamur\Catalog\Controller\Cms;

class Category extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $this->load->model('cms/category');

        $languageParam = 'language=' . $this->config->get('config_language');
        $slug = $this->request->get['slug'] ?? null;
        $category_id = (int)($this->request->get['category_id'] ?? 0);

        $category = $slug ? $this->model_cms_category->getCategoryBySlug($slug) : $this->model_cms_category->getCategory($category_id);
        if (!$category) {
            $this->response->redirect($this->url->link('error/not_found'));
            return;
        }

        $page = max(1, (int)($this->request->get['page'] ?? 1));
        $limit = (int)($this->config->get('config_pagination') ?? 10);

        $filter = [
            'status' => 'published',
            'category_id' => (int)$category['category_id'],
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        ];

        $posts = $this->model_cms_blog->getPosts($filter);
        $total = $this->model_cms_blog->getTotalPublished(['status' => 'published', 'category_id' => $category['category_id']]);

        $postIds = array_column($posts, 'post_id');
        $postCategories = $this->model_cms_blog->getCategoriesForPosts($postIds);

        $data['posts'] = array_map(function ($post) use ($languageParam, $postCategories) {
            $post['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($post['slug']));
            $post['reading_time'] = $post['reading_time'] ?? 0;
            $post['tags_list'] = $post['tags'] ? array_map('trim', explode(',', $post['tags'])) : [];
            $cats = $postCategories[$post['post_id']] ?? [];
            $post['categories'] = array_map(function ($cat) use ($languageParam) {
                $cat['href'] = $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($cat['slug']));
                return $cat;
            }, $cats);
            return $post;
        }, $posts);

        $data['pagination'] = $this->load->controller('common/pagination', [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'url' => $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($category['slug']) . '&page={page}')
        ]);

        $data['heading_title'] = sprintf($this->language->get('text_category_heading'), $category['name']);
        $data['text_read_more'] = $this->language->get('text_read_more');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_published_on'] = $this->language->get('text_published_on');
        $data['text_read_time'] = $this->language->get('text_read_time');
        $data['text_minutes'] = $this->language->get('text_minutes');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_tags'] = $this->language->get('text_tags');
        $data['text_filters'] = $this->language->get('text_filters');
        $data['text_latest_posts'] = $this->language->get('text_latest_posts');
        $data['text_top_posts'] = $this->language->get('text_top_posts');
        $data['entry_search'] = $this->language->get('entry_search');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['text_filters_reset'] = $this->language->get('text_filters_reset');
        $data['filter_tag'] = '';
        $data['filter_category_id'] = (int)$category['category_id'];
        $data['filter_search'] = '';

        $data['categories'] = array_map(function ($cat) use ($languageParam) {
            $cat['href'] = $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($cat['slug']));
            return $cat;
        }, $this->model_cms_category->getCategories());

        $data['tags'] = array_map(function ($tag) use ($languageParam) {
            $tag['href'] = $this->url->link('cms/tag', $languageParam . '&tag=' . urlencode($tag['slug'] ?: $tag['name']));
            return $tag;
        }, $this->model_cms_blog->getTags(30));

        $data['latest_posts'] = array_map(function ($p) use ($languageParam) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
            return $p;
        }, $this->model_cms_blog->getLatestPosts(4));

        $data['top_posts'] = array_map(function ($p) use ($languageParam) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
            return $p;
        }, $this->model_cms_blog->getTopPosts(4));

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', $languageParam)
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('cms/blog', $languageParam)
            ],
            [
                'text' => $category['name'],
                'href' => $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($category['slug']))
            ]
        ];

        $title = $category['meta_title'] ?: $category['name'];
        $this->document->setTitle($title);
        if (!empty($category['meta_description'])) {
            $this->document->setDescription($category['meta_description']);
        }
        if (!empty($category['meta_keywords'])) {
            $this->document->setKeywords($category['meta_keywords']);
        }
        $this->document->addLink($this->url->link('cms/category', $languageParam . '&slug=' . urlencode($category['slug']), true), 'canonical');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $data['link_blog'] = $this->url->link('cms/blog', $languageParam);
        $data['link_tag_base'] = $this->url->link('cms/tag', $languageParam);
        $data['link_category_base'] = $this->url->link('cms/category', $languageParam);

        $this->response->setOutput($this->load->view('cms/blog_list', $data));
    }
}
