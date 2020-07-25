<?php

namespace app\models;

use app\DB;

class User
{
	private $id;
	private $login;
	private $email;
	private $name;
	private $surname;
	private $password;
	private $photo;
	private $created_at;

	//getUser

	//createUser
	public function createUser()
	{
		$db = new DB();
		$link = $db->getConnection();
		//$user = $_POST['user'];
		//$user['password'] = hash('whirlpool', $user['password']);
		//$user['token'] = md5($user['email']);

		$sql = "INSERT INTO users (login, name, surname, password, email, token, created_at)
VALUES (:login, :name, :surname, :password, :email, :token, '2020-07-22T15:00:00.000Z')";
		$sth = $link->prepare($sql);
		$sth->bindParam(':login', $_POST['login']);
		$sth->bindParam(':name', $_POST['name']);
		$sth->bindParam(':surname', $_POST['surname']);
		$sth->bindParam(':password', hash('whirlpool', $_POST['password']));
		$sth->bindParam(':email', $_POST['email']);
		$sth->bindParam(':token', md5($_POST['email']));
		$sth->execute();
	}

	//deleteUser


}