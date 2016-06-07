<?php

class ProductCategoryController extends BackendController
{
	public function actionCreate()
	{
		// $_SERVER['REQUEST_METHOD']
		// $_POST['submit']
		// $_POST['name']
		$productCategoryModel = new ProductCategoryModel('product_category');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			/**
			 * 1. 收集表单数据
			 */
			$productCategory = array();
			$productCategory['name'] = $_POST['cat_name'];
			$productCategory['unit'] = $_POST['unit'];
			$productCategory['parent_id'] = $_POST['parent_id'];
			$productCategory['display_order'] = $_POST['sort_order'];
			$productCategory['is_show'] = $_POST['is_show'];
			$productCategory['description'] = $_POST['cat_desc'];
			/**
			 * 2. 验证输入数据合法性和过滤
			 * 1. 同一个父级分类下，不允许出现相同的分类名，反之可以。
			 * 2. 显示顺序必须为整数，做一个转换
			 * 3. is_show是否显示必须为0，1中的一个
			 */
			$productCategory['name'] = trim($productCategory['name']);

			/**
			 * 3. 调用模型，完成数据入库
			 */
			if ($productCategoryModel->insert($productCategory)) {
				// 插入成功了
				$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '添加产品分类成功。');
			} else {
				$this->redirect('index.php?controller=backend/ProductCategory&action=create', 2, '添加产品分类失败。');
			}
		} else {
			$productCategorys = $productCategoryModel->getList();
			$productCategorys = $productCategoryModel->tree($productCategorys, 0, 0);
			$this->display('backend/product-category/create', array(
				'productCategorys' => $productCategorys,
			));
		}
	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		/*
		 * 1. 判断当前分类是否有子分类
		 */
		$productCategoryModel = new ProductCategoryModel('product_category');
		if ($productCategoryModel->hasChildren($id)) {
			$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '请先删除所有子分类。');
		} else {
			if ($productCategoryModel->delete($id)) {
				$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '删除产品分类成功。');
			} else {
				$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '删除产品分类失败。');
			}
		}
	}

	public function actionUpdate()
	{
		$productCategoryModel = new ProductCategoryModel('product_category');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$productCategory = array();
			$productCategory['id'] = $_GET['id'];
			$productCategory['name'] = $_POST['cat_name'];
			$productCategory['parent_id'] = $_POST['parent_id'];
			$productCategory['unit'] = $_POST['unit'];
			$productCategory['display_order'] = $_POST['sort_order'];
			$productCategory['is_show'] = $_POST['is_show'];
			$productCategory['description'] = $_POST['cat_desc'];

			/*过滤*/
			$productCategory['name'] = trim($productCategory['name']);
			$productCategory['description'] = htmlentities($productCategory['description']);


			if ($productCategoryModel->update($productCategory)) {
				$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '更新产品分类成功。');
			} else {
				$this->redirect('index.php?controller=backend/ProductCategory&action=index', 2, '更新产品分类失败。');
			}
		} else {
			$id = $_GET['id'];
			$productCategory = $productCategoryModel->selectByPk($id);
			$productCategorys = $productCategoryModel->getList();
			$productCategorys = $productCategoryModel->tree($productCategorys, 0, 0);
			$this->display('backend/product-category/update', array(
				'productCategorys' => $productCategorys,
				'productCategory' => $productCategory,
			));
		}
	}

	/*显示商品分类列表页*/
	public function actionIndex()
	{
		/*
		 * 1.从商品分类模型中拿出所有的数据
		 * 2. 将数据传递到视图中
		 **/
		$productCategoryModel = new ProductCategoryModel('product_category');
		$productCategorys = $productCategoryModel->getList();
		$productCategorys = $productCategoryModel->tree($productCategorys);
		$this->display('backend/product-category/index', array(
			'productCategorys' => $productCategorys,
		));
	}
}