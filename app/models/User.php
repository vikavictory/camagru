<?php

namespace app\models;

use app\Model;
use Exception;
use PDOException;

class User extends Model
{
//	private function validateUserCreation()
//	{
//		if (isset($_POST['submit'] && isset($_POST['login']))
//
//	}

	public function createUser()
	{
		$link = self::getDB(); // обработка если нет подключения к БД
		$token = md5($_POST['email'] . "918273645");
		$password = hash('whirlpool', $_POST['password']);
		$created_at = $today = date("Y-m-d H:i:s");
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
		return true;
	}

	public function login()
	{
		//обработка ошибок: нет пользователя, неверный пароль, неактивирован
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
		}
		if (!$result)
			return "нет такого пользователя";

		if (hash('whirlpool', $_POST['password']) === $result['password'])
		{
			if ($result['activated'] === '1')
			{
				$_SESSION['user'] = $_POST['login'];
				return true;
			}
			else
				return "isn't activated";
		}
		else
			return "wrong password";
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

	//deleteUser

	public function getUser($user)
	{
		//обработка ошибок
		//что нельзя посмотреть неактивированного пользователя
		try {
			$link = self::getDB();
			$sql = "SELECT id, login, name, surname, email, activated FROM users WHERE login=:login";
			$sth = $link->prepare($sql);
			$sth->bindParam(':login', $user);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error)
			return false;
		return $result;
	}

}