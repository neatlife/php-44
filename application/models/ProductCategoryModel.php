<?php

class ProductCategoryModel extends Model
{
	public function getList()
	{
		$sql = "SELECT * FROM product_category";
		return $this->db->getAll($sql);
	}

	public function tree($productCategorys, $parentId = 0, $level = 0) {
		static $tree = array();
		foreach($productCategorys as $productCategory) {
			if ($productCategory['parent_id'] == $parentId) {
				$productCategory['level'] = $level;
				$tree[] = $productCategory;
				$this->tree($productCategorys, $productCategory['id'], $level + 1);
			}
		}
		return $tree;
	}

	public function hasChildren($id)
	{
		return $this->total('parent_id="' . $id . '"');
	}

	/*
	 * 拿出分类的具有层级关系的数组
	 *
	 * @return Array 有层级关系的产品分类多维数组
	 **/
	public function getMultiDimension($productCategorys, $parentId = 0, $startLevel = 1, $stopLevel = 3) {
		$tree = array();
		foreach($productCategorys as $productCategory) {
			if ($productCategory['parent_id'] == $parentId) {
				if (($startLevel + 1) <= $stopLevel) {
					$productCategory['childrens'] = $this->getMultiDimension($productCategorys, $productCategory['id'], $startLevel + 1, $stopLevel);
				}
				$tree[] = $productCategory;
			}
		}
		return $tree;
	}
}







