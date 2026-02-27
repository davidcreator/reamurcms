<?php
namespace Reamur\Front\Controller\Extension\Reamur\Module;
class Category extends \Reamur\System\Engine\Controller {
	public function index(): string {
		$this->load->language('extension/reamur/module/category');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = [];
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('front/category');
		
		$this->load->model('front/product');

		$data['categories'] = [];

		$categories = $this->model_front_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = [];

			if ($category['category_id'] == $data['category_id']) {
				$children = $this->model_front_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = [
						'filter_category_id'  => $child['category_id'], 
						'filter_sub_category' => true
					];

					$children_data[] = [
						'category_id' => $child['category_id'],
						'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_front_product->getTotalProducts($filter_data) . ')' : ''),
						'href'        => $this->url->link('product/category', 'language=' . $this->config->get('config_language') . '&path=' . $category['category_id'] . '_' . $child['category_id'])
					];
				}
			}

			$filter_data = [
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			];

			$data['categories'][] = [
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_front_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'language=' . $this->config->get('config_language') . '&path=' . $category['category_id'])
			];
		}

		return $this->load->view('extension/reamur/module/category', $data);
	}
}
