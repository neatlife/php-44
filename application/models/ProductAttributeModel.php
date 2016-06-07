<?php

class ProductAttributeModel extends Model
{
	public function getList($categoryId = 0, $offset = false, $pageSize = false)
	{
		/*
		用程序的方式查出关联的数据
		$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
		$productAttributes = $this->db->getAll('SELECT * FROM product_attribute');
		foreach ($productAttributes as $key => $productAttribute) {
			$productAttributeCategory = $productAttributeCategoryModel->selectByPk($productAttribute['category_id']);
			$productAttribute['category_name'] = $productAttributeCategory['name'];
			$productAttributes[$key] = $productAttribute;
		}
		*/
		$sql = <<<SQL
SELECT 
    pc.name as category_name, pa.*
FROM
    product_attribute as pa
        LEFT JOIN
    product_attribute_category as pc ON pa.category_id = pc.id
SQL;
		if ($categoryId > 0) {
			$sql .= ' WHERE category_id=' . $categoryId;
		}
		if (($offset !== false) && ($pageSize !== false)) {
			$sql .= " limit {$offset}, {$pageSize}";
		}
		return $this->db->getAll($sql);
	}

	public function generateTableByCategoryId($categoryId)
	{
		$sql = 'SELECT * FROM product_attribute WHERE category_id=' . $categoryId;
		$productAttributes = $this->db->getAll($sql);

		$tableHtml = '';
		foreach ($productAttributes as $productAttribute) {
			$tableHtml .= '<tr>';
			$tableHtml .= '<td class="label">' . $productAttribute['name'] . '</td>';
			$tableHtml .= '<td>';
			$tableHtml .= '<input type="hidden" name="attr_id_list[]" value="' . $productAttribute['id'] . '">';
			if ($productAttribute['input_value_type'] == 1) {
				$attributeValues = explode('/', $productAttribute['value']);
				$tableHtml .= '<select name="attr_value_list[]">';
				foreach ($attributeValues as $attributeValue) {
					$tableHtml .= '<option value="' . $attributeValue . '">' . $attributeValue . '</option>';
				}
				$tableHtml .= '</select>';
			} else if ($productAttribute['input_value_type'] == 2) {
				$tableHtml .= '<input name="attr_value_list[]" type="text" value="" size="40">';
			}
			$tableHtml .= '</td>';
			$tableHtml .= '</tr>';
		}

		return $tableHtml;
	}
}