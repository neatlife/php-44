<?php

class ProductAttributeCategoryController extends BackendController
{
	public function actionCreate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->loadHelper('Input');
			$_POST = Input::addslashesRecursive($_POST);

			$productAttributeCategory = array();
			$productAttributeCategory['name'] = $_POST['type_name'];

			/*过滤验证*/
			/**
			 * 1. 比如不能重名
			 */

			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			if ($productAttributeCategoryModel->insert($productAttributeCategory)) {
				return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=index', 2, '添加产品属性成功。');
			} else {
				return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=create', 2, '添加产品属性失败。');
			}
		} else {
			$this->display('backend/product-attribute-category/create');
		}
	}

	public function actionIndex()
	{
		$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');

		$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
		$pageSize = 1;
		$this->loadLibrary('Page');
		$page = new Page($productAttributeCategoryModel->total(''), $pageSize, $currentPage,'index.php', array(
			'controller' => 'backend/ProductAttributeCategory',
			'action' => 'index',
		));

		$productAttributeCategorys = $productAttributeCategoryModel->pageRows(($currentPage - 1) * $pageSize, $pageSize);
		$this->display('backend/product-attribute-category/index', array(
			'productAttributeCategorys' => $productAttributeCategorys,
			'page' => $page->showPage(),
		));
	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
		if ($productAttributeCategoryModel->delete($id)) {
			return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=index', 2, '删除产品属性分类成功。');
		} else {
			return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=index', 2, '删除产品属性分类失败。');
		}
	}

	public function actionUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->loadHelper('Input');
			$_POST = Input::addslashesRecursive($_POST);

			$productAttributeCategory = array();
			$productAttributeCategory['id'] = (int) $_GET['id'];
			$productAttributeCategory['name'] = $_POST['type_name'];

			/*过滤验证*/
			/**
			 * 1. 比如不能重名
			 */

			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			if ($productAttributeCategoryModel->update($productAttributeCategory)) {
				return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=index', 2, '修改产品属性分类成功。');
			} else {
				return $this->redirect('index.php?controller=backend/ProductAttributeCategory&action=update', 2, '修改产品属性分类失败。');
			}
		} else {
			$id = $_GET['id'];
			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			$productAttributeCategory = $productAttributeCategoryModel->selectByPk($id);
			$this->display('backend/product-attribute-category/update', array(
				'productAttributeCategory' => $productAttributeCategory,
			));

		}
	}
}