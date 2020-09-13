<?php

namespace app\controllers;

use app\Model;
use app\models\User;
use app\Router;

class UserController extends Router
{
	private $DIR_PATH = 'app/views/user/';

	public function registration() //+
	{
		if (isset($_POST['submit'])) {
			//var_dump($_POST);
			//var_dump($_FILES);
			$result = User::createUser();
			if ($result === true) {
				$message = "Ваш аккаунт создан, для его активации 
				необходимо перейти по ссылке, направленной Вам на почту";
			} else {
				$message = $result;
			}
		}
		$pathView = $this->DIR_PATH . 'registration.php';
		require_once $pathView;
	}

	public function login() //+
	{
		if (isset($_POST['submit']))
		{
			$result = User::login();
			if ($result === true)
				header('Location: /user/' . $_SESSION['user']);
			else
				$message = $result;
		}
		$pathView = $this->DIR_PATH . 'login.php';
		require_once $pathView;
	}

	public function user($user)
	{

		$user = User::getUser($user);
		if ($user)
		{
			//$this->debug($user);
			$pathView = $this->DIR_PATH . 'useraccount.php';
			require_once $pathView;
		}
		else {
			self::ErrorPage404();
		}
	}

	public function logout() //+
	{
		$_SESSION['user'] = "";
		$_SESSION['user_id'] = "";
		setcookie('user', "", time()-3600, "/");
		setcookie('user_id', "", time()-3600, "/");
		header('Location: /');
	}

	public function token() //+
	{
		if (isset($_GET['token']) && isset($_GET['id']))
		{
			$token = $_GET['token'];
			$id = $_GET['id'];
			$result = User::activateAccount($id, $token);
			if ($result === true) {
				$message = "Аккаунт активирован";
			} else {
				$message = $result;
			}
			$pathView = $this->DIR_PATH . 'token.php';
			require_once $pathView;
		} else {
			$pathView = 'app/views/index.php';
			require_once $pathView;
		}
	}

	public function recovery() //+
	{
		if (isset($_POST['submit']))
		{
			$result = User::sendRecoveryLink();
			if ($result === true) {
				$message = "Ccылка на восстановление пароля отправлена Вам на почту";
			} else {
				$message = $result;
			}
		}
		$pathView = $this->DIR_PATH . 'recovery.php';
		require_once $pathView;
	}

	public function changepassword() //+
	{
		if (isset($_GET['token'])) {
			$result = User::recoveryLinkConfirmation();
			if (isset($result['user_id'])) {
				if (isset($_POST['submit'])) {
					$changeResult = User::changePassword($result['user_id']);
					$message = $changeResult;
				}
			} else {
				$message = $result;
			}
			$pathView = $this->DIR_PATH . 'changepassword.php';
			require_once $pathView;
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
