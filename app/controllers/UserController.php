<?php

namespace app\controllers;

use app\Model;
use app\models\User;

class UserController extends Model
{
	private $DIR_PATH = 'app/views/user/';

	public function registration()
	{
		if (isset($_POST['submit']))
		{
			$result = User::createUser();
			if ($result === true)
				$_SESSION['message'] = "Ваш аккаунт создан, для его активации 
				необходимо перейти по ссылке, которая была направлена Вам на почту";
			else
			{
				if (strpos($result, "login"))
					$message = "Такой пользователь уже зарегестрирован.";
				if (strpos($result, "email"))
					$message = "Такая почта уже зарегестрирована.";
				$_SESSION['message'] = "Произошла ошибка при регистрации. " . $message;
			}
		}
		$pathView = $this->DIR_PATH . 'registration.php';
		require_once $pathView;
	}

	public function login()
	{
		if (isset($_POST['submit']))
		{
			$result = User::login();
			if ($result === true)
				header('Location: /user/' . $_SESSION['user']);
			else
				$message = $result;
			$_SESSION['message'] = $message;;
		}
		$pathView = $this->DIR_PATH . 'login.php';
		require_once $pathView;
	}

	public function user($user)
	{
		$user = User::getUser($user);
		//$user = new User($user);
		//$result = $user->getUser($user);
		if ($user)
		{
			$pathView = $this->DIR_PATH . 'useraccount.php';
			require_once $pathView;
		}
		else
			self::ErrorPage404();
	}

	public function logout()
	{
		$_SESSION['user'] = "";
		header('Location: /');
	}

	public function token()
	{
		if (isset($_GET['token']) && isset($_GET['id']))
		{
			$token = $_GET['token'];
			$id = $_GET['id'];
			$result = User::activateAccount($id, $token);
			if ($result)
			{
				$pathView = $this->DIR_PATH . 'token.php';
				require_once $pathView;
			}
			else
				echo "error";
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
