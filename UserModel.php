<?php

namespace Model;

class UserModel extends BaseModel
{
	private static $salt='supersalt';
	
	public static function create_admin()
	{
		$table_name=self::tablename();
		$ADMIN_CREATE_QUERY="INSERT 
		INTO 
		$table_name
		SET
		  login='admin'
		, password='".md5('123'.self::$salt)."'
		, is_admin=1;";
		if ($res = mysqli_query(\App\Application::$DBLink,$ADMIN_CREATE_QUERY))
			return TRUE;
		else
			return FALSE;
	}
	
	public static function login($login,$password)
	{
		if  (!preg_match( '/^[A-Za-z0-9 ]{3,20}$/i',$login))
			return FALSE;
		
		$table_name=self::tablename();
		$LOGIN_QUERY="SELECT 
		  login 
		, is_admin
		FROM 
		$table_name
		WHERE
		login='$login'
		AND
		password='".md5($password.self::$salt)."'
		;";
		$res = mysqli_query(\App\Application::$DBLink,$LOGIN_QUERY);
		$user=mysqli_fetch_assoc($res);
		if (isset($user['login']))
			return $user['login'];
		else
			return FALSE;
	}
	
}
?>