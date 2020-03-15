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
			$data=['text'=>'<p class="lead" style="color:red;">Запись добавлена</p>'];
		else
			$data=['text'=>'<p class="lead" style="color:red;">Ошибка добавления записи</p>'];
		self::indexAction($data);
	}
	
	protected function editAction()
	{
		if (!\App\Application::IsAdmin())
		{
			$data=['text'=>'<p class="lead" style="color:red;">Перелогиньтесь! Ошибка при редактировании записи</p>'];
		}
		else
			if (static::$Model::edit_note(static::$Request['get']['id'],static::$Request['post']['text']))
				$data=['text'=>'<p class="lead" style="color:red;">Запись Отредактирована</p>'];
			else
				$data=['text'=>'<p class="lead" style="color:red;">Ошибка при редактировании записи</p>'];
		self::indexAction($data);
	}
	
	protected function aquireAction()
	{
		if (!\App\Application::IsAdmin())
			$data=['text'=>'<p class="lead" style="color:red;">Перелогиньтесь! Ошибка при редактировании записи</p>'];
		else
			if (static::$Model::revert_status(static::$Request['get']['id']))
				$data=['text'=>'<p class="lead" style="color:red;">Запись Отредактирована</p>'];
			else
				$data=['text'=>'<p class="lead" style="color:red;">Ошибка при редактировании записи</p>'];
		self::indexAction($data);
	}
}
?>