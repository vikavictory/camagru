<?php

namespace app\models;

use app\Model;

class User extends Model
{
	private $link;

	private function validateUser()
	{
		//что такой пользователь уже существует
		//что такой логин уже существует
	}

	public function createUser()
	{
		$link = self::getDB();


		//вставить валидацию

		$token = md5($_POST['email'] . "918273645");
		$password = hash('whirlpool', $_POST['password']);
		$created_at = $today = date("Y-m-d H:i:s");
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
	}

	public function login()
	{
		$link = self::getDB();

		echo "here";
		$sql = "SELECT password FROM users WHERE login=:login";
		$sth = $link->prepare($sql);
		$sth->bindParam(':login', $_POST['login']);
		$sth->execute();
		$result = $sth->fetch(\PDO::FETCH_ASSOC);
		print_r($result);
		if (hash('whirlpool', $_POST['password']) === $result['password'])
			echo "OK";
		else
			echo "KO";
		return $result;

	}

	//deleteUser

	//getUser

}