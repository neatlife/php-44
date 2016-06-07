<?php

class Controller
{
	public function display($viewName, $data = array())
    {
        extract($data);
        include VIEWS_PATH . '/' . $viewName . '.php';
    }

    public function redirect($url, $type = 1, $message = '', $watiSecond = 3)
    {
        if ($type == 1) {
            header('Location: ' . $url);
        } else if ($type == 2) {
            $this->display('message', array(
                'waitSecond' => $watiSecond,
                'url' => $url,
                'message' => $message,
			));
        }
        die();
    }

    public function loadHelper($helperName)
    {
        include HELPERS_PATH . '/' . $helperName . '.php';
    }

    public function loadLibrary($libraryName)
    {
        include LIBRARY_PATH . '/' . $libraryName . '.php';
    }
}
