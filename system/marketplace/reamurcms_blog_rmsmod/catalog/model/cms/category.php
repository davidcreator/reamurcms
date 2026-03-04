<?php
namespace Reamur\Catalog\Model\Cms;

class Category extends \Reamur\System\Engine\Model {
    public function getCategory(int $category_id): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE category_id = '" . (int)$category_id . "' AND status = 1");
        return $query->row ?? [];
    }

    public function getCategoryBySlug(string $slug): array {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE slug = '" . $this->db->escape($slug) . "' AND status = 1");
        return $query->row ?? [];
    }

    public function getCategories(): array {
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE status = 1 ORDER BY sort_order, name")->rows ?? [];
    }
}
