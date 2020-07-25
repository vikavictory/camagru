<?php

namespace app\controllers;

use app\Model;
use app\models\User;

class UserController extends Model
{
	public function registration()
	{
		if (isset($_POST['submit']))
			$result = User::createUser();
		$pathView = 'app/views/user/registration.php';
		require_once $pathView;
	}

	public function login()
	{
		if (isset($_POST['submit']))
			$result = User::login();
		$pathView = 'app/views/user/login.php';
		require_once $pathView;
	}
}