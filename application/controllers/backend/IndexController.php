<?php

class IndexController extends BackendController
{
    public function actionIndex()
    {
        $this->display('backend/index/index');
    }

    public function actionTop()
    {
        $this->display('backend/index/top');
    }

    public function actionMenu()
    {
        $this->display('backend/index/menu');
    }

    public function actionMain()
    {
        $this->display('backend/index/main');
    }

    public function actionDrag()
    {
        $this->display('backend/index/drag');
    }
}
