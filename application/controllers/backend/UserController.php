<?php

class UserController extends Controller
{
	public function actionLogin()
	{
		$this->loadHelper('Input');
		$_POST = Input::addslashesRecursive($_POST);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			/*
			 * 0. 检查验证码
			 * 1. 收集登录信息(用户名和密码)
			 * 2. 过滤数据, 检查数据的合法性
			 * 3. 判断用户是否存在
			 * 4. 存在：跳转到后台首页，不存在：返回登陆页并给错误提示。
			 */

			/* 0. 检查验证码 */	
			$captchaCode = $_POST['captcha'];
			$realCaptchaCode = $_SESSION['captchaCode'];
			if ($realCaptchaCode != strtolower($captchaCode)) {
				return $this->redirect('index.php?controller=backend/User&action=login', 2, '验证码错误。');
			}

			/**
			 * 1. 收集登录信息(用户名和密码)
			 */
			$adminUser = array();
			$adminUser['username'] = $_POST['username'];
			$adminUser['password'] = $_POST['password'];

			/*
			 * 2. 过滤数据, 检查数据的合法性
			 */

			if (!$adminUser['username']) {
				return $this->redirect('index.php?controller=backend/User&action=login', 2, '用户名不能为空。');
			}
			if (!$adminUser['password']) {
				return $this->redirect('index.php?controller=backend/User&action=login', 2, '密码不能为空。');
			}
			$adminUser['username'] = trim($adminUser['username']);
			$adminUser['password'] = trim($adminUser['password']);

			/*
			 * 3. 判断用户是否存在
			 */
			$adminUserModel = new AdminUserModel('admin_user');
			/* 4. 存在：跳转到后台首页，不存在：返回登陆页并给错误提示。*/
			if ($adminUserModel->checkUsernameAndPassword($adminUser)) {
				/* 5. 将登录标志存入session */
				$_SESSION['adminUser'] = $adminUser;
				return $this->redirect('index.php?controller=backend/Index&action=index', 2, '登录成功。');
			} else {
				return $this->redirect('index.php?controller=backend/User&action=login', 2, '登录失败。');
			}
		} else {
			$this->display('backend/user/login');
		}
	}

	public function actionLogout()
	{
		unset($_SESSION['adminUser']);
		/**
		 * 不可能销毁所有的键
		 */
		session_destroy();

		return $this->redirect('index.php?controller=backend/User&action=login', 2, '退出登录成功。');
	}

	/**
	 * 输出一张验证码
	 */
	public function actionCaptcha()
	{
		/**
		 * 1. 加载验证码图片生成类
		 * 2. 输出图片
		 * 3.将验证码保存到SESSION中，以备在验证登录的时候提前验证验证码的使用
		 */
		$this->loadLibrary('Captcha');
		$captcha = new Captcha();
		// 将图片发送到浏览器
		$captcha->generateCode();
		$_SESSION['captchaCode'] = $captcha->getCode();
	}
}