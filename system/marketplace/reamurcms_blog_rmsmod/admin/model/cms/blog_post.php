<?php
namespace Reamur\Admin\Model\Cms;

class BlogPost extends \Reamur\System\Engine\Model {
    public function ensureTables(): void {
        $this->load->helper('blog_installer');
        $installer = new \BlogInstaller($this->db);
        $installer->blogTablesExist() ? $installer->upgradeBlogTables() : $installer->installBlogTables();
    }

    public function add(array $data): int {
        $reading_time = $this->calculateReadingTime((string)($data['content'] ?? ''));
        $meta_title = $data['meta_title'] ?? $data['title'] ?? '';
        $meta_description = $this->normalizeMetaDescription($data['meta_description'] ?? ($data['excerpt'] ?? ''));
        $meta_keywords = $data['meta_keywords'] ?? '';
        $canonical_url = $data['canonical_url'] ?? '';
        $tags = $data['tags'] ?? '';
        $schema_json = $data['schema_json'] ?? '';
        $og_image = $data['og_image'] ?? ($data['featured_image'] ?? '');
        $is_featured = !empty($data['is_featured']) ? 1 : 0;

        $this->db->query("INSERT INTO `" . DB_PREFIX . "blog_post` SET 
            author_id = '" . (int)($data['author_id'] ?? 0) . "',
            title = '" . $this->db->escape((string)$data['title']) . "',
            content = '" . $this->db->escape((string)$data['content']) . "',
            excerpt = '" . $this->db->escape((string)($data['excerpt'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            og_image = '" . $this->db->escape((string)$og_image) . "',
            tags = '" . $this->db->escape((string)$tags) . "',
            meta_title = '" . $this->db->escape((string)$meta_title) . "',
            meta_description = '" . $this->db->escape((string)$meta_description) . "',
            meta_keywords = '" . $this->db->escape((string)$meta_keywords) . "',
            canonical_url = '" . $this->db->escape((string)$canonical_url) . "',
            schema_json = '" . $this->db->escape((string)$schema_json) . "',
            reading_time = '" . (int)$reading_time . "',
            is_featured = '" . (int)$is_featured . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_added = NOW(),
            date_modified = NOW()");

        $post_id = $this->db->getLastId();
        $this->bumpCacheVersion();

        return $post_id;
    }

    public function edit(int $post_id, array $data): void {
        $reading_time = $this->calculateReadingTime((string)($data['content'] ?? ''));
        $meta_title = $data['meta_title'] ?? $data['title'] ?? '';
        $meta_description = $this->normalizeMetaDescription($data['meta_description'] ?? ($data['excerpt'] ?? ''));
        $meta_keywords = $data['meta_keywords'] ?? '';
        $canonical_url = $data['canonical_url'] ?? '';
        $tags = $data['tags'] ?? '';
        $schema_json = $data['schema_json'] ?? '';
        $og_image = $data['og_image'] ?? ($data['featured_image'] ?? '');
        $is_featured = !empty($data['is_featured']) ? 1 : 0;

        $this->db->query("UPDATE `" . DB_PREFIX . "blog_post` SET 
            title = '" . $this->db->escape((string)$data['title']) . "',
            content = '" . $this->db->escape((string)$data['content']) . "',
            excerpt = '" . $this->db->escape((string)($data['excerpt'] ?? '')) . "',
            slug = '" . $this->db->escape((string)$data['slug']) . "',
            status = '" . $this->db->escape((string)($data['status'] ?? 'draft')) . "',
            featured_image = '" . $this->db->escape((string)($data['featured_image'] ?? '')) . "',
            og_image = '" . $this->db->escape((string)$og_image) . "',
            tags = '" . $this->db->escape((string)$tags) . "',
            meta_title = '" . $this->db->escape((string)$meta_title) . "',
            meta_description = '" . $this->db->escape((string)$meta_description) . "',
            meta_keywords = '" . $this->db->escape((string)$meta_keywords) . "',
            canonical_url = '" . $this->db->escape((string)$canonical_url) . "',
            schema_json = '" . $this->db->escape((string)$schema_json) . "',
            reading_time = '" . (int)$reading_time . "',
            is_featured = '" . (int)$is_featured . "',
            published_at = " . ($data['published_at'] ? "'" . $this->db->escape((string)$data['published_at']) . "'" : "NULL") . ",
            date_modified = NOW()
            WHERE post_id = '" . (int)$post_id . "'");

        $this->bumpCacheVersion();
    }

    public function delete(int $post_id): void {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "'");
        $this->bumpCacheVersion();
    }

    public function getPost(int $post_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "'");
        return $query->row ?? [];
    }

    public function getPosts(array $filter = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $sql .= " ORDER BY date_added DESC";

        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 20);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 20;
        $sql .= " LIMIT " . $start . "," . $limit;

        return $this->db->query($sql)->rows;
    }

    public function getTotalPosts(array $filter = []): int {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_post` WHERE 1";
        if (!empty($filter['status'])) {
            $sql .= " AND status = '" . $this->db->escape((string)$filter['status']) . "'";
        }
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    private function bumpCacheVersion(): void {
        if (isset($this->cache)) {
            $version = 'blog-' . uniqid('', true);
            $this->cache->set('blog.cache.v', $version, 604800); // 7 days
        }
    }

    private function calculateReadingTime(string $content): int {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = (int)ceil($wordCount / 200);
        return max($minutes, 1);
    }

    private function normalizeMetaDescription(string $description): string {
        $description = trim(strip_tags(htmlspecialchars_decode($description, ENT_QUOTES)));
        if (strlen($description) > 160) {
            return substr($description, 0, 157) . '...';
        }
        return $description;
    }
}
