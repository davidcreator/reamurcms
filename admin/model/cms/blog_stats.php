<?php
namespace Reamur\Admin\Model\Cms;

class BlogStats extends \Reamur\System\Engine\Model {
    public function getSummary(): array {
        $sql = "SELECT 
            SUM(views) as views,
            SUM(unique_views) as unique_views,
            SUM(likes) as likes,
            SUM(shares) as shares
        FROM `" . DB_PREFIX . "blog_analytics`";
        $row = $this->db->query($sql)->row;
        return [
            'views' => (int)($row['views'] ?? 0),
            'unique_views' => (int)($row['unique_views'] ?? 0),
            'likes' => (int)($row['likes'] ?? 0),
            'shares' => (int)($row['shares'] ?? 0),
        ];
    }

    public function getTopPosts(int $limit = 10): array {
        $limit = max(1, min($limit, 50));
        $sql = "SELECT p.post_id, p.title, p.status, p.published_at, p.date_added, a.views, a.unique_views, a.likes, a.shares
                FROM `" . DB_PREFIX . "blog_post` p
                LEFT JOIN `" . DB_PREFIX . "blog_analytics` a ON a.blog_post_id = p.post_id
                ORDER BY a.views DESC, a.unique_views DESC
                LIMIT " . (int)$limit;
        return $this->db->query($sql)->rows;
    }
}
