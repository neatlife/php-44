<?php

class ProductBrandModel extends Model
{
	public function getList()
	{
		$sql = "SELECT * FROM product_brand";
		return $this->db->getAll($sql);
	}
}