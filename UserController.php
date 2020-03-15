<?php

namespace Contr;

class UserController extends BaseController
{
	protected function admin_createAction()
	{
		if (static::$Model::create_admin())
			\View\UserView::render('Админ создан!');
		else
			\View\UserView::render('ОШИБКА!');
	}
	
	protected function loginAction()
	{
		if (!\App\Application::IsRegistered())
		{
			if ($user_login=static::$Model::login(static::$Request['post']['login'],static::$Request['post']['password']))
			{
				\App\Application::RegisterUser($user_login);
				header("Location: /");
				die();
			}
			else
				\View\UserView::render('Введенные данные неверны!');
		}
		else
			\View\UserView::render('Пользователь уже вошел!');
	}
	
	protected function logoutAction()
	{
		if (\App\Application::UnregisterUser())
		{
			header("Location: /");
			die();
			\View\UserView::render('Пользователь разлогинен');
		}
	}
}
?>