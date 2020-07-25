<?php

namespace app\controllers;

use app\models\User;

class UserController
{
	public function registration()
	{
		if (isset($_POST['submit']))
			$result = User::createUser();
		$pathView = 'app/views/user/registration.php';
		require_once $pathView;
	}
}