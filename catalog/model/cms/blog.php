<?php
namespace Reamur\Catalog\Model\Cms;

class Blog extends \Reamur\System\Engine\Model {
    public function getPosts(array $data = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE status = 'published'";
        $sql .= " ORDER BY published_at DESC NULLS LAST, date_added DESC";
        $start = (int)($data['start'] ?? 0);
        $limit = (int)($data['limit'] ?? 10);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 10;
        $sql .= " LIMIT " . $start . "," . $limit;
        return $this->db->query($sql)->rows;
    }

    public function getPost(int $post_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "' AND status = 'published'");
        return $query->row ?? [];
    }

    public function getPostBySlug(string $slug): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 'published'");
        return $query->row ?? [];
    }

    public function getLayoutId(int $post_id): int {
        // Placeholder: return default layout
        return 0;
    }
}
