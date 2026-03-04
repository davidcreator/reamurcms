<?php
namespace Reamur\Catalog\Controller\Common;
/**
 * Class Menu
 *
 * @package Reamur\Catalog\Controller\Common
 */
class Menu extends \Reamur\System\Engine\Controller {
	/**
	 * @return string
	 */
	public function index(): string {
		$this->load->language('common/menu');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = [];

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = [];

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = [
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					];

					$children_data[] = [
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'language=' . $this->config->get('config_language') . '&path=' . $category['category_id'] . '_' . $child['category_id'])
					];
				}

				// Level 1
				$data['categories'][] = [
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'language=' . $this->config->get('config_language') . '&path=' . $category['category_id'])
				];
			}
		}

		// CMS shortcuts
		$data['categories'][] = [
			'name'     => $this->language->get('text_blog'),
			'children' => [],
			'column'   => 1,
			'href'     => $this->url->link('cms/blog', 'language=' . $this->config->get('config_language'))
		];

		$data['categories'][] = [
			'name'     => $this->language->get('text_landpage'),
			'children' => [],
			'column'   => 1,
			'href'     => $this->url->link('cms/landpage', 'language=' . $this->config->get('config_language'))
		];

		$data['categories'][] = [
			'name'     => $this->language->get('text_mooc'),
			'children' => [],
			'column'   => 1,
			'href'     => $this->url->link('cms/mooc', 'language=' . $this->config->get('config_language'))
		];

		return $this->load->view('common/menu', $data);
	}
}
