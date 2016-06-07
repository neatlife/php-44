<?php

class ProductBrandController extends BackendController
{
	/**
	 * 添加商品品牌
	 */
	public function actionCreate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			/**
			 * 1. 收集表单数据
			 */
			$productBrand = array();
			$productBrand['name'] = $_POST['brand_name'];
			$productBrand['description'] = $_POST['brand_desc'];
			$productBrand['display_order'] = $_POST['sort_order'];
			$productBrand['is_show'] = $_POST['is_show'];
			/*
			 * 2. 验证表单数据
			 * 		1. 品牌名称不能重复
			 *		2. 显示顺序必须为整数
			 *		3. 是否显示只能为0或1
			 */
			$productBrandModel = new ProductBrandModel('product_brand');
			// "name='" . "华为" . "'"
			// "name='华为'"
			if ($productBrandModel->total("name='" . $productBrand['name'] . "'")) {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '商品品牌已存在。');
			}
			$productBrand['display_order'] = intval($productBrand['display_order']);
			if (!in_array($productBrand['is_show'], array(0, 1))) {
				$productBrand['is_show'] = 0;
			}

			/**
			 * 处理文件上传
			 */
			$this->loadLibrary('Upload');
			$upload = new Upload();
			$imagePath = $upload->up($_FILES['logo']);
			if ($imagePath) {
				$productBrand['image_path'] = $imagePath;
			} else {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '上传图片失败');
			}

			/*
			 * 3. 往数据库增加一条记录
			 */
			if ($productBrandModel->insert($productBrand)) {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '商品品牌添加成功。');
			} else {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '商品品牌添加失败。');
			}
		} else {
			$this->display('backend/product-brand/create');
		}
	}

	public function actionIndex()
	{
		/**
		 * 1. 从模型中拿出所有数据
		 * 2. 在视图中显示
		 */
		$productBrandModel = new ProductBrandModel('product_brand');
		$productBrands = $productBrandModel->getList();
		$this->display('backend/product-brand/index', array(
			'productBrands' => $productBrands,
		));
	}

	public function actionDelete()
	{
		/**
		 * 1. 确定要删除的范围，商品品牌的id
		 * 2. 调用模型的删除方法删除记录
		 */
		$id = $_GET['id'];
		$productBrandModel = new ProductBrandModel('product_brand');
		if ($productBrandModel->delete($id)) {
			$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '删除商品品牌成功。');
		} else {
			$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '删除商品品牌失败。');
		}
	}

	public function actionUpdate()
	{
		$productBrandModel = new ProductBrandModel('product_brand');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$productBrand = array();
			$productBrand['id'] = $_GET['id'];
			$productBrand['name'] = $_POST['brand_name'];
			$productBrand['description'] = addslashes(htmlentities($_POST['brand_desc']));
			$productBrand['display_order'] = $_POST['sort_order'];
			$productBrand['is_show'] = $_POST['is_show'];
			/*验证提交的数据*/
			// "name='" . "华为" . "'"
			// "name='华为'"
			if ($productBrandModel->total("name='" . $productBrand['name'] . "' AND id !=" . $productBrand['id'])) {
				return $this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '商品品牌已存在。');
			}

			if (isset($_FILES['logo']) && ($_FILES['logo']['error'] == 0)) {
				/*处理商品品牌的图片上传*/
				$this->loadLibrary('Upload');
				$upload = new Upload();
				$imagePath = $upload->up($_FILES['logo']);
				if ($imagePath) {
					$productBrand['image_path'] = $imagePath;
				} else {
					$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '上传图片失败。');
				}
			}

			/*调用模型，完成数据更新*/
			if ($productBrandModel->update($productBrand)) {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '修改商品品牌成功。');
			} else {
				$this->redirect('index.php?controller=backend/ProductBrand&action=index', 2, '修改商品品牌失败。');
			}
		} else {
			$id = $_GET['id'];
			$productBrand = $productBrandModel->selectByPk($id);
			$this->display('backend/product-brand/update', array(
				'productBrand' => $productBrand,
			));
		}
		/**
		 * 1. 确定要修改的记录，通过id定位
		 * 2. 在视图编辑记录
		 * 3. 上传修改后的记录
		 * 4. 调用模型更新数据
		 */
	}
}







