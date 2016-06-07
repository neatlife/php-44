<?php

class BackendController extends Controller
{
	/**
	 * 判断用户是否登录
	 */
	public function __construct()
	{
		/**
		 * 1. 判断用户是否登录
		 * 2. 没登陆，跳转到登录页面，并且die/exist
		 * 3. 已登录，放行
		 */
        // 完成判断是否登录状态
        if (!$this->checkLogged()) {
            $this->redirect('index.php?controller=backend/User&action=login', 2, '请先登录。');
            die;
        }
	}

	protected function checkLogged()
	{
		return isset($_SESSION['adminUser']);
	}
}