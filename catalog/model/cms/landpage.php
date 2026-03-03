<?php
namespace Reamur\Catalog\Model\Cms;

class Landpage extends \Reamur\System\Engine\Model {
    public function getPageBySlug(string $slug): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "landpage_page` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 'published'");
        $page = $query->row ?? [];
        if ($page) {
            $page['html'] = $this->getLatestRevisionHtml((int)$page['page_id']);
        }
        return $page;
    }

    private function getLatestRevisionHtml(int $page_id): string {
        $query = $this->db->query("SELECT html FROM `" . DB_PREFIX . "landpage_page_revision` WHERE page_id = '" . (int)$page_id . "' ORDER BY revision_id DESC LIMIT 1");
        return $query->row['html'] ?? '';
    }
}
