<?php

namespace app\models;

use app\Model;
use Exception;
use PDOException;

class User extends Model
{
	public function getUser($user)
	{
		//обработка ошибок
		//что нельзя посмотреть неактивированного пользователя
		try {
			$link = self::getDB();
			$sql = "SELECT id, login, name, surname, email, token, activated FROM users WHERE login=:login";
			$sth = $link->prepare($sql);
			$sth->bindParam(':login', $user);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;
	}

	private function validateUserCreation()
	{
		if (isset($_POST['submit']) && isset($_POST['login']) &&
		isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) &&
		isset($_POST['password']) && isset($_POST['password2']))
		{
			if (!(preg_match("/^[a-z][a-z0-9]{1,20}$/", $_POST['login'])))
				return "Некорректный логин. Логин может включать в себя только цифры 
					и маленькие латинские буквы.";
			if (!(preg_match("/^[A-Z][a-z]{1,30}$/", $_POST['name'])))
				return "Некорректное имя.";
			if (!(preg_match("/^[A-Z][a-z]{1,30}$/", $_POST['surname'])))
				return "Некорректная фамилия.";
			if (!(preg_match("/(?=.*[0-9])(?=.*[a-zA-Z])/", $_POST['password'])))
				return "Некорректный пароль.";
			if ($_POST['password'] !== $_POST['password2'])
				return "Пароли не совпадают.";
		}
		else
			return "Введены не все данные";
		return true;
	}

	private function sendToken($user)
	{
		$data = User::getUser($user);
		$subject = "Camagru - Confirmation of registration";
		$message = "Для подтверждения регистрации пройдите по ссылке: " .
			self::ADDRESS . "/token?id=" . $data['id'] . "&token=" . $data['token'];
		$result = self::sendMail($data['email'], $subject, $message);
		return $result;
	}

	public function createUser()
	{
		$link = self::getDB(); // обработка если нет подключения к БД
		$token = md5($_POST['email'] . "918273645");
		$password = hash('whirlpool', $_POST['password']);
		$created_at = date("Y-m-d H:i:s");
		$validation = self::validateUserCreation();
		if ($validation !== true)
			return $validation;
		try {
			$sql = "INSERT INTO users (login, name, surname, password, email, token, created_at)
			VALUES (:login, :name, :surname, :password, :email, :token, :created_at)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':login', $_POST['login']);
			$sth->bindParam(':name', $_POST['name']);
			$sth->bindParam(':surname', $_POST['surname']);
			$sth->bindParam(':password', $password);
			$sth->bindParam(':email', $_POST['email']);
			$sth->bindParam(':token', $token);
			$sth->bindParam(':created_at', $created_at);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}

		$result = self::sendToken($_POST['login']);
		if ($result)
			echo "OK";
		else
			echo "KO";
		return true;
	}

	public function login()

	{
		//обработка ошибок: нет пользователя, неверный пароль, не активирован
		$link = self::getDB();
		try {
			$sql = "SELECT password, activated FROM users WHERE login=:login";
			$sth = $link->prepare($sql);
			$sth->bindParam(':login', $_POST['login']);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		} if (!$result) {
			return "Пользователя не существует";
		}

		if (hash('whirlpool', $_POST['password']) === $result['password']) {
			if ($result['activated'] === '1')
			{
				$_SESSION['user'] = $_POST['login'];
				return true;
			} else {
				return "Аккаунт не активирован";
			}
		} else {
			return "Неправильный пароль";
		}
	}

	public function activateAccount($id, $token)
	{
		//обработка ошибок
		//добавить, что уже активирован
		$link = self::getDB();
		$sql = "SELECT token FROM users WHERE id=:id";
		$sth = $link->prepare($sql);
		$sth->bindParam(':id', $id);
		$sth->execute();
		$result = $sth->fetch(\PDO::FETCH_ASSOC);
		if ($result['token'] === $token)
		{
			$sql = "UPDATE users SET activated = '1' WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $id);
			$sth->execute();
			return true;
		}
		else
			return false;
	}

	public function sendRecoveryLink()
	{
		//подумать, как вынести проверки отдельно!!!

		if (isset($_POST['email']))
		{
			//проверить есть ли такая почта
			$email = $_POST['email'];
			$link = self::getDB();
			try {
				$sql = "SELECT id FROM users WHERE email=:email";
				$sth = $link->prepare($sql);
				$sth->bindParam(':email', $_POST['email']);
				$sth->execute();
				$result_id = $sth->fetch(\PDO::FETCH_ASSOC);
			} catch( PDOException $e) {
				return $e->getMessage();
			} catch( Exception $e) {
				return $e->getMessage();
			}
			if (!($result_id))
				return "Пользователь не найден";

			//проверить, отправлено ли такое письмо
			try {
				$sql = "SELECT id FROM reset_password WHERE user_id=:user_id";
				$sth = $link->prepare($sql);
				$sth->bindParam(':user_id', $result_id['id']);
				$sth->execute();
				$result = $sth->fetch(\PDO::FETCH_ASSOC);
			} catch( PDOException $e) {
				return $e->getMessage();
			} catch( Exception $e) {
				return $e->getMessage();
			}
			if ($result)
				return "Ссылка уже направлена";



			//сохранить токен во временную таблицу
			$token = bin2hex(random_bytes(16));
			$created_at = date("Y-m-d H:i:s");

			try {
				$sql = "INSERT INTO reset_password (user_id, token, created_at)
			VALUES (:user_id, :token, :created_at)";
				$sth = $link->prepare($sql);
				$sth->bindParam(':user_id', $result_id['id']);
				$sth->bindParam(':token', $token);
				$sth->bindParam(':created_at', $created_at);
				$sth->execute();
			} catch( PDOException $e) {
				return $e->getMessage();
			} catch( Exception $e) {
				return $e->getMessage();
			}

			$subject = "Camagru - Password Recovery";
			$message = "Для смены пароля пройдите по ссылке: " .
				self::ADDRESS . "/recovery?token=" . $token;
			$result = self::sendMail($_POST['email'], $subject, $message);
			return $result;
		}
	}

	public function recoveryLinkConfirmation()
	{
		if (isset($_GET['token'])) {
			$link = self::getDB();
			try {
				$sql = "SELECT user_id FROM reset_password WHERE token=:token";
				$sth = $link->prepare($sql);
				$sth->bindParam(':token', $_GET['token']);
				$sth->execute();
				$result = $sth->fetch(\PDO::FETCH_ASSOC);
			} catch( PDOException $e) {
				return $e->getMessage();
			} catch( Exception $e) {
				return $e->getMessage();
			}
		}

		if (!($result)) {
			return "Cсылка не активна";
		} else {
			return $result;
		}
	}

	public function changePassword()
	{
		// проверка пароля (разбить функцию валидации на несколько);
		// проверить что пароль не совпадает с предыдущим;
		//
	}

	//deleteUser
}