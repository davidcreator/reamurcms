<?php
namespace Reamur\Catalog\Controller\Api\Cms;

class Blog extends \Reamur\System\Engine\Controller {
    public function interact(): void {
        $this->load->model('cms/blog');

        $payload = $this->jsonInput();
        $post_id = (int)($payload['post_id'] ?? 0);
        $action = $payload['action'] ?? '';
        $actorKey = $payload['actor_key'] ?? ($this->request->server['REMOTE_ADDR'] ?? '');

        if ($post_id <= 0 || !$action) {
            $this->respondJson(['error' => 'Missing post_id or action'], 400);
            return;
        }

        $analytics = $this->model_cms_blog->trackInteraction($post_id, $action, $actorKey);
        $this->respondJson(['status' => 'ok', 'analytics' => $analytics]);
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
