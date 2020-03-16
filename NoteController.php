<?php

namespace Contr;

class NoteController extends BaseController
{
	private static $Sorting = '';
	private static $Direction = 'DESC';
	private static $Page = 1;
	
	public function __construct($action,$request)
	{
		$constr=parent::__construct($action,$request);
		if (isset(static::$Request['get']['sorting']))
			self::$Sorting = static::$Request['get']['sorting'];
		if (isset(static::$Request['get']['page']))
			self::$Page = static::$Request['get']['page'];
		if (isset(static::$Request['get']['direction']))
			self::$Direction = static::$Request['get']['direction'];
		
	}
	protected function indexAction($data=[])
	{
		if ($rows=static::$Model::get_notes(self::$Sorting,self::$Page,self::$Direction))
			$data=array_merge($data,$rows);
		
		if (self::$Sorting!='')
		{
			$data['sorting'] = '&sorting='.self::$Sorting.'&direction='.self::$Direction;
		}
		else
			$data['sorting'] = ''; 
			
		
		$data['page']=self::$Page;
		
		\View\NoteView::render($data);
	}
	
	protected function addAction()
	{
		if (static::$Model::add_note(static::$Request['post']['username'],static::$Request['post']['email'],static::$Request['post']['text']))
			$data=['text'=>'Запись добавлена'];
		else
			$data=['text'=>'Ошибка добавления записи'];
		self::indexAction($data);
	}
	
	protected function editAction()
	{
		if (!\App\Application::IsAdmin())
		{
			$data=['text'=>'Перелогиньтесь! Ошибка при редактировании записи'];
		}
		else
			if (static::$Model::edit_note(static::$Request['get']['id'],static::$Request['post']['text']))
				$data=['text'=>'Запись Отредактирована'];
			else
				$data=['text'=>'Ошибка при редактировании записи'];
		self::indexAction($data);
	}
	
	protected function aquireAction()
	{
		if (!\App\Application::IsAdmin())
			$data=['text'=>'Перелогиньтесь! Ошибка при редактировании записи'];
		else
			if (static::$Model::revert_status(static::$Request['get']['id']))
				$data=['text'=>'Запись Отредактирована'];
			else
				$data=['text'=>'Ошибка при редактировании записи'];
		self::indexAction($data);
	}
}
?>