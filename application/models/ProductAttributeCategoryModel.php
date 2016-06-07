<?php

class ProductAttributeCategoryModel extends Model
{
	public function getList() {
		return $this->db->getAll('SELECT * FROM product_attribute_category');
	}
}