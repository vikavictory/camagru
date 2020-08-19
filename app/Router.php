<?php

namespace app;

use app\controllers\UserController;
use app\controllers\PhotoController;

Class Router extends Model
{
	private $USER_ACTIONS = ['registration', 'activate', 'login', 'logout',
		'settings', 'user', 'token', 'recovery', 'changepassword'];
	private $PHOTO_ACTIONS = ['', 'photo', 'save', 'try', 'preview'];

	protected function getUri()
	{
		return trim($_SERVER['REQUEST_URI'], '/');
	}

	protected function getPath($uri)
	{
		return parse_url($uri, PHP_URL_PATH);
	}

	protected function getRoutes($path)
	{
		return explode('/', $path);
	}

	private function getController($route)
	{
		if (array_search($route, $this->USER_ACTIONS) !== FALSE)
			return 'UserController';
		if (array_search($route, $this->PHOTO_ACTIONS) !== FALSE)
			return 'PhotoController';
		else
			return FALSE;
	}

	public function start()
	{
		$uri = $this->getUri();
		$path = $this->getPath($uri);
		$routes = $this->getRoutes($path);
		$action = $routes[0];
		$controller_name = Router::getController($action);

		if ($controller_name && count($routes) <= 2)
		{
			//проверка на количество routes 1-2
			if ($controller_name === "PhotoController")
			{
				$controller = new PhotoController;
				if ($action === '') {
					$controller->gallery();
				} else if ($action === "photo" && count($routes) === 2) {
					$photo_id = $routes[1];
					$controller->getOnePhoto($photo_id);
				} else {
					$controller->$action();
				}
			}

			if ($controller_name === "UserController")
			{
				$controller = new UserController;
				if ($action === "user" && count($routes) === 2) {
					$user = $routes[1];
					$controller->user($user);
				} else if ($action !== "user" && count($routes) === 1) {
					$controller->$action();
				} else {
					self::ErrorPage404();
				}
			}
		} else {
			self::ErrorPage404();
		}
	}

	private function ErrorPage404()
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
	}

}