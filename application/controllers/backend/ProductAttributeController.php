<?php

class ProductAttributeController extends BackendController
{
	public function actionIndex()
	{
		$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
		$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

		$productAttributeModel = new ProductAttributeModel('product_attribute');
		// 拿出所有的商品属性分类
		$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');

		$this->loadLibrary('Page');
		$pageSize = 1;
		$totalCondition = '';
		if ($categoryId) {
			$totalCondition = "category_id='{$categoryId}'";
		}
		$page = new Page($productAttributeModel->total($totalCondition), $pageSize, $currentPage, 'index.php', array(
			'controller' => 'backend/ProductAttribute',
			'action' => 'index',
			'category_id' => $categoryId,
		));
		$pageHtml = $page->showPage();
		$offset = ($currentPage - 1) * $pageSize;

		$productAttributes = $productAttributeModel->getList($categoryId, $offset, $pageSize);
		$productAttributeCategorys = $productAttributeCategoryModel->getList();
		$this->display('backend/product-attribute/index', array(
			'productAttributes' => $productAttributes,
			'productAttributeCategorys' => $productAttributeCategorys,
			'categoryId' => $categoryId,
			'pageHtml' => $pageHtml,
		));
	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		$productAttributeModel = new ProductAttributeModel('product_attribute');
		if ($productAttributeModel->delete($id)) {
			return $this->redirect('index.php?controller=backend/ProductAttribute&action=index', 2, '删除成功。');
		} else {
			return $this->redirect('index.php?controller=backend/ProductAttribute&action=index', 2, '删除失败。');
		}
	}

	public function actionCreate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$productAttribute = array();
			$productAttribute['name'] = $_POST['attr_name'];
			$productAttribute['category_id'] = $_POST['type_id'];
			$productAttribute['input_value_type'] = $_POST['attr_input_type'];
			$productAttribute['value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : '';

			/*过滤和验证数据*/
			$this->loadHelper('Input');
			$productAttribute = Input::addslashesRecursive($productAttribute);

			/*调用模型进行写库的操作*/
			$productAttributeModel = new ProductAttributeModel('product_attribute');
			if ($productAttributeModel->insert($productAttribute)) {
				return $this->redirect('index.php?controller=backend/ProductAttribute&action=index', 2, '添加成功: ' . $productAttribute['name']);
			} else {
				return $this->redirect('index.php?controller=backend/ProductAttribute&action=create', 2, '添加失败: ' . $productAttribute['name']);
			}
		} else {
			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			$productAttributeCategorys = $productAttributeCategoryModel->getList();
			$this->display('backend/product-attribute/create', array(
				'productAttributeCategorys' => $productAttributeCategorys,
			));
		}
	}

	public function actionUpdate()
	{

		$productAttributeModel = new ProductAttributeModel('product_attribute');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$productAttribute = array();
			$productAttribute['id'] = $_GET['id'];
			$productAttribute['name'] = $_POST['attr_name'];
			$productAttribute['category_id'] = $_POST['type_id'];
			$productAttribute['input_value_type'] = $_POST['attr_input_type'];
			$productAttribute['value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : '';

			/*过滤和验证数据*/
			$this->loadHelper('Input');
			$productAttribute = Input::addslashesRecursive($productAttribute);

			/*拿到修改之前的数据*/
			$oldProductAttribute = $productAttributeModel->selectByPk($productAttribute['id']);
			if (比较$productAttribute和$oldProductAttribute键和值是否都没变) {
				return $this->redirect('index.php?controller=backend/ProductAttribute&action=index', 2, '什么都没改: ' . $productAttribute['name']);
			}

			/*调用模型进行写库的操作*/
			if ($productAttributeModel->update($productAttribute)) {
				return $this->redirect('index.php?controller=backend/ProductAttribute&action=index', 2, '修改成功: ' . $productAttribute['name']);
			} else {
				return $this->redirect('index.php?controller=backend/ProductAttribute&action=create', 2, '修改失败: ' . $productAttribute['name']);
			}
		} else {
			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			$productAttributeCategorys = $productAttributeCategoryModel->getList();
			$id = $_GET['id'];
			$productAttribute = $productAttributeModel->selectByPk($id);
			$this->display('backend/product-attribute/update', array(
				'productAttributeCategorys' => $productAttributeCategorys,
				'productAttribute' => $productAttribute,
			));
		}
	}
}