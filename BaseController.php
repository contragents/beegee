<?php

namespace Contr;

class BaseController
{
	public static $Request;
	public static $Action;
	public static $Model;
	
	public function __construct($action,$request)
	{
		self::$Request = $request;
		self::$Action = $action;
		$modelname = 'Model\\'.ucfirst(\App\Application::$URI[0]).'Model';
		self::$Model = new $modelname();
	}
	
	public function Run()
	{
		return call_user_func('static::'.self::$Action.'Action');
	}
	
	
}
?>