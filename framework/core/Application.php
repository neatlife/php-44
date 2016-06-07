<?php

class Application
{
    public static function run()
    {
        /**
         * 1. 具体框架代码执行之前：加载配置，定义常量
         */
        self::init();

        /**
         * 2. 文件按需加载：注册自动加载函数
         */
        self::registerAutoload();

        /**
         * 3. 完成路由解析，调用业务逻辑，获得调用结果字符串，完成输出。
         */
        self::dispatch();
    }

    protected static function init()
    {
        define('BASE_PATH', dirname(getcwd()));
        // application 业务逻辑代码相关的常量
        define('CONFIG_PATH', BASE_PATH . '/application/config');
        define('CONTROLLERS_PATH', BASE_PATH . '/application/controllers');
        define('CONTROLLERS_COMMON_PATH', CONTROLLERS_PATH . '/common');
        define('MODELS_PATH', BASE_PATH . '/application/models');
        define('VIEWS_PATH', BASE_PATH . '/application/views');
        // framework 框架常用路径的定义
        define('FRAMEWORK_PATH', BASE_PATH . '/framework');
        define('CORE_PATH', FRAMEWORK_PATH . '/core');
        define('DB_PATH', FRAMEWORK_PATH . '/db');
        define('HELPERS_PATH', FRAMEWORK_PATH . '/helpers');
        define('LIBRARY_PATH', FRAMEWORK_PATH . '/library');

        // 上传路径
        define('UPLOAD_PATH', BASE_PATH . '/public/upload');

        // 加载配置
        $GLOBALS['database'] = require(CONFIG_PATH . '/database.php');

        // 加载核心控制器
        require CORE_PATH . '/Controller.php';
        require DB_PATH . '/Mysql.php';
        require CORE_PATH . '/Model.php';

        // session
        session_start();
    }

    protected static function registerAutoload()
    {
       /**
        * 那些文件需要自动加载
        * 1. 不确定加不加载的文件
        * 第一类: 控制器文件
        * 第二类: 模型文件
        */ 
        spl_autoload_register('self::load');
    }

    protected static function load($className)
    {
        if (substr($className, '-5') == 'Model') {
            include MODELS_PATH . '/' . $className . '.php';
        }
        // application/controllers/common目录里的控制器才自动加载
        if (substr($className, '-10') == 'Controller') {
            include CONTROLLERS_COMMON_PATH . '/' . $className . '.php';
        }
    }

    protected static function dispatch()
    {
        // controller=frontend/Product&action=index        
        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'Index';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        $controllerClass = $controller . 'Controller';
        require CONTROLLERS_PATH . '/' . $controllerClass . '.php';
        $actionName = 'action' . $action;
        /**
         * 完成业务逻辑的调用, 在上层代码中，是一个方法的调用
         */
        // backend/ProductBrandController
        $controllerParts = explode('/', $controllerClass);
        // array(
        //     'backend',
        //     'ProductBrandController'
        // );
        $controllerName = $controllerParts[count($controllerParts) - 1];
        // 或者： $controllerName = end($controllerParts);
        
        $controllerInstance = new $controllerName();
        $controllerInstance->$actionName();
    }
}














