<?php
namespace Reamur\Catalog\Model\Cms;

class Landpage extends \Reamur\System\Engine\Model {
    public function getPages(array $filter = []): array {
        $start = (int)($filter['start'] ?? 0);
        $limit = (int)($filter['limit'] ?? 12);

        $sql = "SELECT page_id, title, slug, featured_image, meta_description, published_at 
                FROM `" . DB_PREFIX . "landpage_page`
                WHERE status = 'published'
                ORDER BY published_at DESC, page_id DESC
                LIMIT " . $start . "," . $limit;

        $query = $this->db->query($sql);
        $rows = $query->rows ?? [];

        foreach ($rows as &$row) {
            if (!empty($row['published_at'])) {
                $row['published_at'] = date('c', strtotime($row['published_at']));
            }
        }
        return $rows;
    }

    public function getTotalPages(): int {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "landpage_page` WHERE status = 'published'");
        return (int)($query->row['total'] ?? 0);
    }

    public function getPageBySlug(string $slug): array {
        $query = $this->db->query("SELECT *, is_premium, owner_id, payout_share, price FROM `" . DB_PREFIX . "landpage_page` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 'published'");
        $page = $query->row ?? [];
        if ($page) {
            $page['html'] = $this->getLatestRevisionHtml((int)$page['page_id']);
            if (!empty($page['published_at'])) {
                $page['published_at'] = date('c', strtotime($page['published_at']));
            }
        }
        return $page;
    }

    private function getLatestRevisionHtml(int $page_id): string {
        $query = $this->db->query("SELECT html FROM `" . DB_PREFIX . "landpage_page_revision` WHERE page_id = '" . (int)$page_id . "' ORDER BY revision_id DESC LIMIT 1");
        return $query->row['html'] ?? '';
    }
}
