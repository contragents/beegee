<?php
/*
Класс приложения.
Выполняет базовые задачи:
Разбирает URI
Вызывает соответствующий контроллер
Управляет активными пользователями и сессиями
Устанавливает связь с БД и предоставляет ссылку на подключение
*/

namespace App;

class Application
{
    public static $DBLink;
	public static $URI;
	
	public function __construct($config)
    {
        self::$DBLink = mysqli_connect($config['db']['host'],$config['db']['username'],$config['db']['password'],$config['db']['database']);
		session_start();
		//Разбиваем URI на контроллер-экшн..
		$URI=parse_url($_SERVER['REQUEST_URI']);
		if ($URI['path'] == '/')
			$URI['path'] = $config['default_route'];
		if (substr($URI['path'],0,1) == '/')
			$URI['path'] = substr($URI['path'],1);
		$URI = explode('/',$URI['path']);
		
		if (count($URI) == 1)
			foreach($config['routes'][$URI[0]] as $action => $value)
				if (is_array($value) && isset($value['default']))
				{
					$URI[1]=$action;
					break;
				}
				
		self::$URI = $URI;
    }
	
	public function Run()
	{
		
		if (count(self::$URI) != 2)
			exit('Ошибка в URI!!!');
		$controller = 'Contr\\'.ucfirst(self::$URI[0]).'Controller';
		$action=self::$URI[1];
		$request=[
			'get' => $_GET,
			'post' => $_POST
			];
		(new $controller($action,$request))->Run();
		
	}
	
	public static function IsAdmin()
	{
		if (isset($_SESSION['login']) && $_SESSION['login']=='admin')
			return TRUE;
		else
			return FALSE;
	}
	
	public static function IsRegistered()
	{
		if (isset($_SESSION['login']))
			return TRUE;
		else
			return FALSE;
	}
	
	public static function RegisterUser($login)
	{
		if(empty(trim($login))) 
			return FALSE;
		else 
			if (!preg_match('/^[a-z0-9]{3,20}$/i', $login))
				return FALSE;
			else
			{
				$_SESSION['login']=$login;
				return TRUE;
			}			
	}
	
	public static function UnregisterUser()
	{
		unset($_SESSION['login']);
		return TRUE;
	}
	
}
?>