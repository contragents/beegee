<?php

namespace Model;

class BaseModel
{
		
	public function __construct()
	{
		//var_dump(\App\Application::$DBLink);
		return;
	}
	
	public function Run()
	{
		return;
	}
	
	public static function tablename()
	{
		return \App\Application::$URI[0].'s';
	}
}
?>