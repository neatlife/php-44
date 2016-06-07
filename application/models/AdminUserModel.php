<?php

class AdminUserModel extends Model
{
	/**
	 * @param Array $adminUser 用户名和密码的关联数组
	 * 
	 * @return Boolean 存在返回true，不存在返回false
	 */
	public function checkUsernameAndPassword($adminUser)
	{
		return (bool) $this->total("username='{$adminUser['username']}' AND password='{$adminUser['password']}'");
	}
}