<?php
namespace Reamur\Catalog\Controller\Api\Cms;

class Comment extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->model('cms/blog');

        $post_id = (int)($this->request->get['post_id'] ?? 0);
        $slug = $this->request->get['slug'] ?? null;
        $limit = (int)($this->request->get['limit'] ?? 50);

        if (!$post_id && $slug) {
            $post = $this->model_cms_blog->getPostBySlug($slug);
            $post_id = (int)($post['post_id'] ?? 0);
        }

        if ($post_id <= 0) {
            $this->respondJson(['error' => 'Missing post_id or slug'], 400);
            return;
        }

        $comments = $this->model_cms_blog->getComments($post_id, 1, $limit);
        $this->respondJson(['data' => $comments]);
    }

    public function create(): void {
        $this->load->language('cms/blog');
        $this->load->model('cms/blog');
        $cache = $this->registry->has('cache') ? $this->registry->get('cache') : null;

        $payload = array_merge($this->request->post, $this->jsonInput());
        $post_id = (int)($payload['post_id'] ?? 0);
        $slug = $payload['slug'] ?? null;

        if (!$post_id && $slug) {
            $post = $this->model_cms_blog->getPostBySlug($slug);
            $post_id = (int)($post['post_id'] ?? 0);
        }

        if ($post_id <= 0) {
            $this->respondJson(['error' => 'Missing post_id or slug'], 400);
            return;
        }

        $author = trim($payload['author'] ?? '');
        $email = trim($payload['email'] ?? '');
        $content = trim($payload['content'] ?? '');
        $website = trim($payload['website'] ?? '');

        $errors = [];
        if (strlen($author) < 2) {
            $errors['author'] = $this->language->get('error_comment_author');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = $this->language->get('error_comment_email');
        }
        if (strlen($content) < 5 || strlen($content) > 2000) {
            $errors['content'] = $this->language->get('error_comment_content');
        }

        $requireLogin = (int)$this->config->get('blog_comment_require_login');
        if ($requireLogin && (!$this->customer || !$this->customer->isLogged())) {
            $errors['permission'] = $this->language->get('error_comment_permission');
        }

        if ($this->model_cms_blog->isSpam($content)) {
            $errors['content'] = $this->language->get('error_comment_spam');
        }

        $rateLimit = (int)($this->config->get('blog_comment_rate_limit') ?? 0);
        if ($rateLimit > 0 && $cache) {
            $actor = $this->request->server['REMOTE_ADDR'] ?? 'anon';
            $minuteKey = 'blog:comment:' . md5($actor . date('YmdHi') . ':' . $post_id);
            $count = (int)$cache->get($minuteKey);
            if ($count >= $rateLimit) {
                $errors['rate'] = $this->language->get('error_comment_rate');
            } else {
                $cache->set($minuteKey, $count + 1, 120);
            }
        }

        if ($errors) {
            $this->respondJson(['errors' => $errors], 400);
            return;
        }

        $status = $this->config->get('blog_comment_auto_approve') ? 1 : 0;
        $comment_id = $this->model_cms_blog->addComment([
            'post_id' => $post_id,
            'author' => $author,
            'email' => $email,
            'website' => $website,
            'content' => $content,
            'status' => $status
        ]);

        $this->respondJson([
            'status' => 'ok',
            'comment_id' => $comment_id,
            'message' => $status ? $this->language->get('text_comment_published') : $this->language->get('text_comment_pending')
        ], 201);
    }

    private function jsonInput(): array {
        $raw = file_get_contents('php://input');
        if (!$raw) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function respondJson(array $payload, int $status = 200): void {
        if (!headers_sent()) {
            http_response_code($status);
            $this->response->addHeader('Content-Type: application/json');
        }
        $this->response->setOutput(json_encode($payload));
    }
}
