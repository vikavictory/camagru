<?php

namespace app;

use app\controllers\UserController;

Class Router
{
	//protected function getUri()
	public function getUri()
	{
		return trim($_SERVER['REQUEST_URI'], '/');
	}

	public function getPath($uri)
	{
		return parse_url($uri, PHP_URL_PATH);
	}

	public function start()
	{
		$uri = $this->getUri();
		$path = $this->getPath($uri);

		$controller = new UserController;
		//$action = "registration";
		$controller->registration();
	}

}