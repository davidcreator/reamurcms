<?php
namespace Reamur\Catalog\Model\Cms;

class Blog extends \Reamur\System\Engine\Model {
    private function ttl(): int {
        $configured = (int)($this->config->get('blog_cache_ttl') ?? 600);
        return $configured > 0 ? $configured : 600;
    }

    public function getPosts(array $data = []): array {
        $cache = $this->cacheInstance();
        $status = $data['status'] ?? 'published';
        $search = trim($data['search'] ?? '');
        $tag = trim($data['tag'] ?? '');
        $isFeatured = !empty($data['is_featured']);
        $categoryId = (int)($data['category_id'] ?? 0);
        $order = $data['order'] ?? 'latest'; // latest | popular

        $start = (int)($data['start'] ?? 0);
        $limit = (int)($data['limit'] ?? 10);
        if ($start < 0) $start = 0;
        if ($limit < 1) $limit = 10;

        $cacheKey = $this->cacheKey('blog.posts', [
            'status' => $status,
            'search' => $search,
            'tag' => $tag,
            'is_featured' => $isFeatured,
            'category_id' => $categoryId,
            'order' => $order,
            'start' => $start,
            'limit' => $limit
        ]);

        if ($cache && ($cached = $cache->get($cacheKey))) {
            return $cached;
        }

        $sql = "SELECT p.* FROM `" . DB_PREFIX . "blog_post` p";
        if ($categoryId) {
            $sql .= " INNER JOIN `" . DB_PREFIX . "blog_post_to_category` pc ON pc.post_id = p.post_id";
        }
        if ($order === 'popular') {
            $sql .= " LEFT JOIN `" . DB_PREFIX . "blog_analytics` ba ON ba.blog_post_id = p.post_id";
        }
        $sql .= " WHERE 1";
        if ($status) {
            $sql .= " AND p.status = '" . $this->db->escape($status) . "'";
        }
        if ($search !== '') {
            $escaped = $this->db->escape($search);
            $sql .= " AND (p.title LIKE '%" . $escaped . "%' OR p.content LIKE '%" . $escaped . "%' OR p.tags LIKE '%" . $escaped . "%')";
        }
        if ($tag !== '') {
            $escapedTag = $this->db->escape($tag);
            $sql .= " AND FIND_IN_SET('" . $escapedTag . "', p.tags)";
        }
        if ($isFeatured) {
            $sql .= " AND p.is_featured = 1";
        }
        if ($categoryId) {
            $sql .= " AND pc.category_id = '" . $categoryId . "'";
        }

        if ($order === 'popular') {
            $sql .= " ORDER BY ba.views DESC, ba.likes DESC, (p.published_at IS NULL), p.published_at DESC";
        } else {
            $sql .= " ORDER BY (p.published_at IS NULL), p.published_at DESC, p.date_added DESC";
        }
        $sql .= " LIMIT " . $start . "," . $limit;

        $rows = $this->db->query($sql)->rows;

        if ($cache) {
            $cache->set($cacheKey, $rows, $this->ttl());
        }

        return $rows;
    }

    public function getTotalPublished(array $filter = []): int {
        $cache = $this->cacheInstance();
        $status = $filter['status'] ?? 'published';
        $search = trim($filter['search'] ?? '');
        $tag = trim($filter['tag'] ?? '');
        $categoryId = (int)($filter['category_id'] ?? 0);

        $cacheKey = $this->cacheKey('blog.total', [
            'status' => $status,
            'search' => $search,
            'tag' => $tag,
            'category_id' => $categoryId
        ]);

        if ($cache && ($cached = $cache->get($cacheKey))) {
            return (int)$cached;
        }

        $sql = "SELECT COUNT(DISTINCT p.post_id) AS total FROM `" . DB_PREFIX . "blog_post` p";
        if ($categoryId) {
            $sql .= " INNER JOIN `" . DB_PREFIX . "blog_post_to_category` pc ON pc.post_id = p.post_id";
        }
        $sql .= " WHERE 1";
        if ($status) {
            $sql .= " AND p.status = '" . $this->db->escape($status) . "'";
        }
        if ($search !== '') {
            $escaped = $this->db->escape($search);
            $sql .= " AND (p.title LIKE '%" . $escaped . "%' OR p.content LIKE '%" . $escaped . "%' OR p.tags LIKE '%" . $escaped . "%')";
        }
        if ($tag !== '') {
            $escapedTag = $this->db->escape($tag);
            $sql .= " AND FIND_IN_SET('" . $escapedTag . "', p.tags)";
        }
        if ($categoryId) {
            $sql .= " AND pc.category_id = '" . $categoryId . "'";
        }

        $query = $this->db->query($sql);
        $total = (int)($query->row['total'] ?? 0);

        if ($cache) {
            $cache->set($cacheKey, $total, $this->ttl());
        }

        return $total;
    }

    public function getPost(int $post_id): array {
        $cache = $this->cacheInstance();
        $cacheKey = $this->cacheKey('blog.post.id', ['id' => $post_id]);
        if ($cache && ($cached = $cache->get($cacheKey))) {
            return $cached;
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE post_id = '" . (int)$post_id . "' AND status = 'published'");
        $row = $query->row ?? [];

        if ($row && $cache) {
            $cache->set($cacheKey, $row, $this->ttl());
        }

        return $row;
    }

    public function getPostBySlug(string $slug): array {
        $cache = $this->cacheInstance();
        $cacheKey = $this->cacheKey('blog.post.slug', ['slug' => $slug]);
        if ($cache && ($cached = $cache->get($cacheKey))) {
            return $cached;
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_post` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 'published'");
        $row = $query->row ?? [];

        if ($row && $cache) {
            $cache->set($cacheKey, $row, $this->ttl());
        }

        return $row;
    }

    public function trackInteraction(int $post_id, string $action, string $actorKey = '', array $meta = []): array {
        $cache = $this->cacheInstance();
        $post_id = (int)$post_id;
        if ($post_id <= 0) {
            return [];
        }

        $this->ensureAnalyticsRow($post_id);
        $now = date('Y-m-d H:i:s');
        $actorHash = $actorKey ? md5($actorKey) : '';

        if ($action === 'view') {
            $uniqueIncrement = 0;
            if ($actorHash && $cache) {
                $viewKey = 'blog:view:' . $post_id . ':' . $actorHash;
                if (!$cache->get($viewKey)) {
                    $uniqueIncrement = 1;
                    $cache->set($viewKey, 1, 86400); // 1 day uniqueness
                }
            }

            $this->db->query("UPDATE `" . DB_PREFIX . "blog_analytics` 
                SET views = views + 1,
                    unique_views = unique_views + " . (int)$uniqueIncrement . ",
                    last_viewed_at = '" . $this->db->escape($now) . "',
                    updated_at = '" . $this->db->escape($now) . "'
                WHERE blog_post_id = '" . $post_id . "'");
        } elseif ($action === 'like') {
            $increment = 1;
            if ($actorHash && $cache) {
                $likeKey = 'blog:like:' . $post_id . ':' . $actorHash;
                if ($cache->get($likeKey)) {
                    $increment = 0; // already liked
                } else {
                    $cache->set($likeKey, 1, 2592000); // 30 days
                }
            }
            if ($increment) {
                $this->db->query("UPDATE `" . DB_PREFIX . "blog_analytics` 
                    SET likes = likes + 1, updated_at = '" . $this->db->escape($now) . "'
                    WHERE blog_post_id = '" . $post_id . "'");
            }
        } elseif ($action === 'unlike') {
            if ($actorHash && $cache) {
                $likeKey = 'blog:like:' . $post_id . ':' . $actorHash;
                if ($cache->get($likeKey)) {
                    $cache->delete($likeKey);
                    $this->db->query("UPDATE `" . DB_PREFIX . "blog_analytics` 
                        SET likes = GREATEST(likes - 1, 0), updated_at = '" . $this->db->escape($now) . "'
                        WHERE blog_post_id = '" . $post_id . "'");
                }
            }
        } elseif ($action === 'share') {
            $this->db->query("UPDATE `" . DB_PREFIX . "blog_analytics` 
                SET shares = shares + 1, updated_at = '" . $this->db->escape($now) . "'
                WHERE blog_post_id = '" . $post_id . "'");
        }

        return $this->getAnalytics($post_id);
    }

    public function getAnalytics(int $post_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_analytics` WHERE blog_post_id = '" . (int)$post_id . "'");
        return $query->row ?? [];
    }

    public function getComments(int $post_id, int $status = 1, int $limit = 50): array {
        $post_id = (int)$post_id;
        $status = (int)$status;
        $limit = $limit > 0 ? min($limit, 200) : 50;

        $query = $this->db->query("SELECT comment_id, author, content, date_added, website 
            FROM `" . DB_PREFIX . "blog_comment` 
            WHERE blog_post_id = '" . $post_id . "' AND status = '" . $status . "' 
            ORDER BY date_added DESC 
            LIMIT " . (int)$limit);

        return $query->rows ?? [];
    }

    public function addComment(array $data): int {
        $post_id = (int)($data['post_id'] ?? 0);
        if ($post_id <= 0) {
            return 0;
        }

        $author = trim($data['author'] ?? '');
        $email = trim($data['email'] ?? '');
        $website = trim($data['website'] ?? '');
        $content = trim($data['content'] ?? '');
        $status = (int)($data['status'] ?? 0); // default pending

        $this->db->query("INSERT INTO `" . DB_PREFIX . "blog_comment` SET
            blog_post_id = '" . $post_id . "',
            customer_id = NULL,
            author = '" . $this->db->escape($author) . "',
            email = '" . $this->db->escape($email) . "',
            website = '" . $this->db->escape($website) . "',
            content = '" . $this->db->escape($content) . "',
            status = '" . $status . "',
            parent_id = NULL,
            date_added = NOW(),
            date_modified = NOW()");

        $comment_id = (int)$this->db->getLastId();

        $cache = $this->cacheInstance();
        if ($cache) {
            $cache->set('blog.cache.v', 'blog-' . uniqid('', true), 604800);
        }

        return $comment_id;
    }

    public function countPublishedComments(int $post_id): int {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment` WHERE blog_post_id = '" . (int)$post_id . "' AND status = 1");
        return (int)($query->row['total'] ?? 0);
    }

    private function ensureAnalyticsRow(int $post_id): void {
        $this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "blog_analytics` 
            SET blog_post_id = '" . $post_id . "',
                created_at = NOW(),
                updated_at = NOW()");
    }

    private function cacheKey(string $prefix, array $filter): string {
        $version = $this->getCacheVersion();
        return $prefix . ':' . $version . ':' . md5(json_encode($filter));
    }

    private function getCacheVersion(): string {
        $cache = $this->cacheInstance();
        $version = $cache ? $cache->get('blog.cache.v') : null;
        if (!$version) {
            $version = 'blog-' . uniqid('', true);
            if ($cache) {
                $cache->set('blog.cache.v', $version, 604800);
            }
        }
        return (string)$version;
    }

    private function cacheInstance(): ?object {
        return ($this->registry->has('cache')) ? $this->registry->get('cache') : null;
    }

    public function getPostCategories(int $post_id): array {
        $query = $this->db->query("SELECT c.category_id, c.name, c.slug, c.parent_id FROM `" . DB_PREFIX . "blog_post_to_category` pc INNER JOIN `" . DB_PREFIX . "blog_category` c ON c.category_id = pc.category_id WHERE pc.post_id = '" . (int)$post_id . "' AND c.status = 1 ORDER BY c.sort_order, c.name");
        return $query->rows ?? [];
    }

    public function getCategoriesForPosts(array $postIds): array {
        $postIds = array_filter(array_map('intval', $postIds));
        if (!$postIds) return [];
        $sql = "SELECT pc.post_id, c.category_id, c.name, c.slug FROM `" . DB_PREFIX . "blog_post_to_category` pc INNER JOIN `" . DB_PREFIX . "blog_category` c ON c.category_id = pc.category_id WHERE pc.post_id IN (" . implode(',', $postIds) . ") AND c.status = 1";
        $rows = $this->db->query($sql)->rows ?? [];
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['post_id']][] = $row;
        }
        return $grouped;
    }

    public function getLatestPosts(int $limit = 5): array {
        $limit = $limit > 0 ? min($limit, 20) : 5;
        $sql = "SELECT post_id, title, slug, published_at, featured_image, excerpt FROM `" . DB_PREFIX . "blog_post` WHERE status = 'published' ORDER BY (published_at IS NULL), published_at DESC, date_added DESC LIMIT " . (int)$limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getTopPosts(int $limit = 5): array {
        $limit = $limit > 0 ? min($limit, 20) : 5;
        $sql = "SELECT p.post_id, p.title, p.slug, p.published_at, p.featured_image, ba.views, ba.likes 
                FROM `" . DB_PREFIX . "blog_post` p 
                LEFT JOIN `" . DB_PREFIX . "blog_analytics` ba ON ba.blog_post_id = p.post_id 
                WHERE p.status = 'published' 
                ORDER BY ba.views DESC, ba.likes DESC, (p.published_at IS NULL), p.published_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getRelatedPosts(int $post_id, int $limit = 4): array {
        $limit = $limit > 0 ? min($limit, 10) : 4;
        $tags = [];
        $row = $this->getPost($post_id);
        if ($row && !empty($row['tags'])) {
            $tags = array_filter(array_map('trim', explode(',', $row['tags'])));
        }
        $tagSql = '';
        if ($tags) {
            $escaped = array_map([$this->db, 'escape'], $tags);
            $likeParts = [];
            foreach ($escaped as $t) {
                $likeParts[] = "FIND_IN_SET('" . $t . "', p.tags)";
            }
            $tagSql = ' OR (' . implode(' OR ', $likeParts) . ')';
        }

        $sql = "SELECT DISTINCT p.post_id, p.title, p.slug, p.published_at, p.featured_image 
                FROM `" . DB_PREFIX . "blog_post` p 
                LEFT JOIN `" . DB_PREFIX . "blog_post_to_category` pc ON pc.post_id = p.post_id 
                WHERE p.post_id != '" . (int)$post_id . "' AND p.status = 'published' 
                  AND (pc.category_id IN (SELECT category_id FROM `" . DB_PREFIX . "blog_post_to_category` WHERE post_id = '" . (int)$post_id . "') " . ($tagSql ? $tagSql : '') . ")
                ORDER BY (p.published_at IS NULL), p.published_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql)->rows ?? [];
    }

    public function getTags(int $limit = 50): array {
        $limit = $limit > 0 ? min($limit, 100) : 50;
        $query = $this->db->query("SELECT name, slug FROM `" . DB_PREFIX . "blog_tag` WHERE status = 1 ORDER BY sort_order, name LIMIT " . (int)$limit);
        return $query->rows ?? [];
    }

    public function isSpam(string $content): bool {
        $list = $this->config->get('blog_comment_spam_words') ?? '';
        if (!$list) return false;
        $lower = mb_strtolower($content);
        foreach (array_filter(array_map('trim', explode(',', $list))) as $word) {
            if ($word === '') continue;
            if (mb_strpos($lower, mb_strtolower($word)) !== false) {
                return true;
            }
        }
        return false;
    }
}
