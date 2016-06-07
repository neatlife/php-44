<?php

/**
 * 前台首页控制器
 */
class IndexController extends Controller
{

    public function actionIndex()
    {
    	$productCategoryModel = new ProductCategoryModel('product_category');
    	$productModel = new ProductModel('product');
    	/*
    	 * 拿出分类的具有层级关系的数组
    	 **/
    	$productCategorys = $productCategoryModel->getList();
    	$productCategorys = $productCategoryModel->getMultiDimension($productCategorys);

    	$specialProducts = $productModel->getSpecials(4);
    	$newProducts = $productModel->getNews(4);
    	$this->display('frontend/Index/index', array(
    		'productCategorys' => $productCategorys,
    		'specialProducts' => $specialProducts,
    		'newProducts' => $newProducts,
    	));
    }
}