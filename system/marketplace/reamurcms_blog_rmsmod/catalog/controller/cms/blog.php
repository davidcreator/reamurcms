<?php
namespace Reamur\Catalog\Controller\Cms;

class Blog extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $this->load->model('cms/category');

        $page = max(1, (int)($this->request->get['page'] ?? 1));
        $limit = (int)($this->config->get('config_pagination') ?? 10);
        $category_id = (int)($this->request->get['category_id'] ?? 0);
        $tagFilter = $this->request->get['tag'] ?? '';
        $search = $this->request->get['q'] ?? '';

        $filter = [
            'status' => 'published',
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
            'search' => $search,
            'tag' => $tagFilter,
            'category_id' => $category_id
        ];

        $posts = $this->model_cms_blog->getPosts($filter);
        $total = $this->model_cms_blog->getTotalPublished([
            'status' => 'published',
            'search' => $filter['search'],
            'tag' => $tagFilter,
            'category_id' => $category_id
        ]);

        $languageParam = 'language=' . $this->config->get('config_language');
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

        $paginationQuery = $languageParam;
        if ($category_id) $paginationQuery .= '&category_id=' . $category_id;
        if ($tagFilter !== '') $paginationQuery .= '&tag=' . urlencode($tagFilter);
        if ($search !== '') $paginationQuery .= '&q=' . urlencode($search);

        $data['pagination'] = $this->load->controller('common/pagination', [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'url' => $this->url->link('cms/blog', $paginationQuery . '&page={page}')
        ]);

        $data['heading_title'] = $this->language->get('heading_title');
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
        $data['filter_tag'] = $tagFilter;
        $data['filter_category_id'] = $category_id;
        $data['filter_search'] = $search;

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

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addLink($this->url->link('cms/blog', $languageParam, true), 'canonical');

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

    public function info(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $this->load->model('cms/category');

        $post_id = (int)($this->request->get['blog_id'] ?? 0);
        $slug = $this->request->get['slug'] ?? null;

        $post = $slug ? $this->model_cms_blog->getPostBySlug($slug) : $this->model_cms_blog->getPost($post_id);

        if (!$post) {
            $this->response->redirect($this->url->link('error/not_found'));
            return;
        }

        $languageParam = 'language=' . $this->config->get('config_language');
        $canonical = $post['canonical_url'] ?: $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($post['slug']), true);

        $title = $post['meta_title'] ?: $post['title'];
        $description = $post['meta_description'] ?: ($post['excerpt'] ?? '');

        try {
            $this->document->setTitle($title);
        } catch (\Exception $e) {
            $this->document->setTitle($post['title']);
        }

        try {
            if ($description) {
                $this->document->setDescription($description);
            }
        } catch (\Exception $e) {
            // Silently ignore overly long meta description
        }

        if (!empty($post['meta_keywords'])) {
            $this->document->setKeywords($post['meta_keywords']);
        }

        $this->document->addLink($canonical, 'canonical');
        $ogImage = $post['og_image'] ?: $post['featured_image'];
        $this->document->addMeta('og:title', $title, 'property');
        $this->document->addMeta('og:description', $description ?: $post['title'], 'property');
        $this->document->addMeta('og:type', 'article', 'property');
        $this->document->addMeta('og:url', $canonical, 'property');
        if ($ogImage) {
            $this->document->addMeta('og:image', $ogImage, 'property');
        }

        $post['tags_list'] = $post['tags'] ? array_map('trim', explode(',', $post['tags'])) : [];
        $post['categories'] = array_map(function ($cat) use ($languageParam) {
            $cat['href'] = $this->url->link('cms/category', $languageParam . '&slug=' . urlencode($cat['slug']));
            return $cat;
        }, $this->model_cms_blog->getPostCategories((int)$post['post_id']));
        $post['reading_time'] = $post['reading_time'] ?: $this->calculateReadingTime($post['content'] ?? '');
        $post['published_human'] = $post['published_at'] ?: $post['date_added'];
        $post['href'] = $canonical;

        $actorKey = ($this->request->server['REMOTE_ADDR'] ?? '') . '|' . ($this->request->server['HTTP_USER_AGENT'] ?? '');
        $analytics = $this->model_cms_blog->trackInteraction((int)$post['post_id'], 'view', $actorKey);

        $comments = $this->model_cms_blog->getComments((int)$post['post_id'], 1, 50);
        $comment_count = $this->model_cms_blog->countPublishedComments((int)$post['post_id']);

        $schema = $post['schema_json'] ?: json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title,
            'description' => $description ?: $post['title'],
            'datePublished' => $post['published_at'] ?: $post['date_added'],
            'dateModified' => $post['date_modified'] ?? $post['published_at'] ?? $post['date_added'],
            'mainEntityOfPage' => $canonical,
            'image' => array_filter([$ogImage ?? $post['featured_image']]),
            'author' => [
                '@type' => 'Organization',
                'name' => $this->config->get('config_name')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->config->get('config_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $this->config->get('config_logo') ?? ''
                ]
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $data['schema_json'] = $schema;
        $data['analytics'] = $analytics;
        $data['post'] = $post;
        $data['comments'] = $comments;
        $data['comment_count'] = $comment_count;
        $data['text_published_on'] = $this->language->get('text_published_on');
        $data['text_read_time'] = $this->language->get('text_read_time');
        $data['text_minutes'] = $this->language->get('text_minutes');
        $data['text_tags'] = $this->language->get('text_tags');
        $data['text_share'] = $this->language->get('text_share');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_leave_comment'] = $this->language->get('text_leave_comment');
        $data['text_comment_pending'] = $this->language->get('text_comment_pending');
        $data['text_no_comments'] = $this->language->get('text_no_comments');
        $data['text_copied'] = $this->language->get('text_copied');
        $data['text_sending'] = $this->language->get('text_sending');
        $data['text_error_network'] = $this->language->get('text_error_network');
        $data['text_error_generic'] = $this->language->get('text_error_generic');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['button_submit'] = $this->language->get('button_submit');
        $data['share_url'] = $canonical;
        $data['text_related_posts'] = $this->language->get('text_related_posts');
        $data['related_posts'] = array_map(function ($p) use ($languageParam) {
            $p['href'] = $this->url->link('cms/blog.info', $languageParam . '&slug=' . urlencode($p['slug']));
            return $p;
        }, $this->model_cms_blog->getRelatedPosts((int)$post['post_id'], 4));

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
                'text' => $post['title'],
                'href' => $canonical
            ]
        ];

        $data['interact_endpoint'] = $this->url->link('api/cms/blog.interact', $languageParam, true);
        $data['comment_endpoint'] = $this->url->link('api/cms/comment.create', $languageParam, true);
        $payload = [
            'post_id' => (int)$post['post_id'],
            'slug' => $post['slug'],
            'actor_key' => hash('sha256', $actorKey)
        ];
        $data['interact_payload'] = htmlspecialchars(json_encode($payload, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');

        $this->document->addScript('catalog/view/js/blog-interact.js', 'footer');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        $data['link_blog'] = $this->url->link('cms/blog', $languageParam);
        $data['link_tag_base'] = $this->url->link('cms/tag', $languageParam);
        $data['link_category_base'] = $this->url->link('cms/category', $languageParam);

        $this->response->setOutput($this->load->view('cms/blog_post', $data));
    }

    private function calculateReadingTime(string $content): int {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = (int)ceil($wordCount / 200);
        return max($minutes, 1);
    }
}
