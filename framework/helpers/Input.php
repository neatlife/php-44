<?php

class Input
{
	/**
	 * 转义多维数组
	 */
	public static function addslashesRecursive($array)
	{
		foreach($array as $key => $item) {
			if (is_string($item)) {
				$array[$key] = addslashes($item);
			} else if (is_array($item)) {
				$array[$key] = self::addslashesRecursive($item);
			}
		}
		return $array;
	}
}

/**
$this->loadHelper('Input');
$_POST;
$_POST = Input::addslashesRecursive($_POST);
 */