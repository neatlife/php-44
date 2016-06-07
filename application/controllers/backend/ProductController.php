<?php

class ProductController extends BackendController
{
	public function actionIndex()
	{
		$this->display('backend/product/index', array(
		));
	}

	public function actionDelete()
	{
		$id = $_GET['id'];
		$productModel = new ProductModel('product');
		if ($productModel->delete($id)) {
			return $this->redirect('index.php?controller=backend/Product&action=index', 2, '删除成功。');
		} else {
			return $this->redirect('index.php?controller=backend/Product&action=index', 2, '删除失败。');
		}
	}

	public function actionCreate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$product = array();
			$product['name'] = $_POST['goods_name'];
			$product['serial_number'] = $_POST['goods_sn'];
			$product['category_id'] = $_POST['cat_id'];
			$product['brand_id'] = $_POST['brand_id'];
			$product['shop_price'] = $_POST['shop_price'];
			$product['market_price'] = $_POST['market_price'];
			$product['description'] = $_POST['goods_desc'];
			$product['on_time'] = $_POST['on_time'];
			$product['is_special'] = $_POST['is_special'];
			$product['is_new'] = $_POST['is_new'];
			$product['is_onsale'] = $_POST['is_onsale'];

			if (isset($_FILES['goods_img'])) {
				$this->loadLibrary('Upload');
				$upload = new Upload();
				$imagePath = $upload->up($_FILES['goods_img']);
				if ($imagePath) {
					$product['image_path'] = $imagePath;
					// 处理缩略图
					// $product['thumb_image_path']
					$this->loadLibrary('Image');
					$image = new Image();
					$thumbImagePath = $image->thumbnail(UPLOAD_PATH . '/' . $product['image_path'], 200, 200, UPLOAD_PATH . '/');
					$product['thumb_image_path'] = $thumbImagePath;
					if (!$product['thumb_image_path']) {
						return $this->redirect('index.php?controller=backend/product&action=create', 2, '缩略图处理失败。');
					}
				} else {
					return $this->redirect('index.php?controller=backend/product&action=create', 2, '图片上传失败：' . $upload->error());
				}
			} else {
				return $this->redirect('index.php?controller=backend/product&action=create', 2, '请先上传图片');
			}

			/*过滤和验证数据*/
			$this->loadHelper('Input');
			$product = Input::addslashesRecursive($product);

			/*调用模型进行写库的操作*/
			$productModel = new ProductModel('product');
			$lastProductId = $productModel->insert($product);
			if ($lastProductId) {
				/*处理属性的保存*/
				/*
				 * 1. 从表单收集属性数据
				 */
				$attributeIdList = $_POST['attr_id_list'];
				$attributeValueList = $_POST['attr_value_list'];

				/*
				 * 2. 过滤和校验
				 * ...
				 */

				/*
				 * 3. 调取模型，插入属性
				 */
				$productAttributeRelModel = new ProductAttributeRelModel('product_attribute_rel');
				/**
				 * 由于属性有多个，所以循环插入
				 */
				foreach ($attributeIdList as $key => $attributeId) {
					$attributeValue = $attributeValueList[$key];
					/*
					 * 收集需要插入的数据
					 **/
					$productAttributeRel = array();
					$productAttributeRel['product_id'] = $lastProductId;
					$productAttributeRel['attribute_id'] = $attributeId;
					$productAttributeRel['value'] = $attributeValue;

					/**
					 * 调取模型执行插入操作
					 */
					$productAttributeRelModel->insert($productAttributeRel);
				}

				return $this->redirect('index.php?controller=backend/product&action=index', 2, '添加成功: ' . $product['name']);
			} else {
				return $this->redirect('index.php?controller=backend/product&action=create', 2, '添加失败: ' . $product['name']);
			}
		} else {
			$productCategoryModel = new ProductCategoryModel('product_category');
			$productCategorys = $productCategoryModel->tree($productCategoryModel->getList());

			$productBrandModel = new ProductBrandModel('product_brand');
			$productBrands = $productBrandModel->getList();

			$productAttributeCategoryModel = new ProductAttributeCategoryModel('product_attribute_category');
			$productAttributeCategorys = $productAttributeCategoryModel->getList();


			$this->display('backend/product/create', array(
				'productBrands' => $productBrands,
				'productCategorys' => $productCategorys,
				'productAttributeCategorys' => $productAttributeCategorys,
			));
		}
	}

	public function actionUpdate()
	{

		$productModel = new ProductModel('product');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$product = array();
			$product['id'] = $_GET['id'];

			/*过滤和验证数据*/
			$this->loadHelper('Input');
			$product = Input::addslashesRecursive($product);

			/*调用模型进行写库的操作*/
			if ($productModel->update($product)) {
				return $this->redirect('index.php?controller=backend/product&action=index', 2, '修改成功');
			} else {
				return $this->redirect('index.php?controller=backend/product&action=create', 2, '修改失败');
			}
		} else {
			$id = $_GET['id'];
			$product = $productModel->selectByPk($id);
			$this->display('backend/product/update', array(				'product' => $product,
			));
		}
	}

	public function actionLoadAttributeTable()
	{
		$productAttributeCategoryId = $_GET['product_attribute_category_id'];

		$productAttributeModel = new ProductAttributeModel('product_attribute');
		$attributeTable = $productAttributeModel->generateTableByCategoryId($productAttributeCategoryId);
		echo <<<HTML
<script type="text/javascript">
	window.parent.document.getElementById('attrTable').innerHTML = '{$attributeTable}';
</script>
HTML;
	}
}









