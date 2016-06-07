<?php

class ProductModel extends Model
{
	public function getSpecials($limit = 4)
	{
		$sql = 'SELECT * FROM product WHERE is_special = 1 limit ' . $limit;
		return $this->db->getAll($sql);
	}

	public function getNews($limit = 4)
	{
		$sql = 'SELECT * FROM product WHERE is_new = 1 limit ' . $limit;
		return $this->db->getAll($sql);
	}
}