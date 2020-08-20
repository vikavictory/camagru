<?php

namespace app\models;

use app\Model;
use app\models\UserValidation;
use app\models\Photo;
use Exception;
use PDOException;

class User extends Model
{
	public static function getUser($user)
	{
		//обработка ошибок
		//что нельзя посмотреть неактивированного пользователя
		try {
			$link = self::getDB();
			$sql = "SELECT id, login, name, surname, email, token, activated, photo FROM users WHERE login=:login";
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
		$userPhotos = Photo::getUserPhoto($result['id']);
		if ($userPhotos) {
			$result['photos'] = $userPhotos;
		}
		return $result;
	}

	public static function getUserLogin($user_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT login FROM users WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $user_id);
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

	private static function sendToken($user) //+
	{
		$data = User::getUser($user);
		$subject = "Camagru - Confirmation of registration";
		$message = "Для подтверждения регистрации пройдите по ссылке: " .
			self::ADDRESS . "/token?id=" . $data['id'] . "&token=" . $data['token'];
		$result = self::sendMail($data['email'], $subject, $message);
		return $result;
	}

	public static function createUser() //+
	{
		$photo = null;
		if (($validation = UserValidation::validateUserCreation()) !== true) {
			return $validation;
		}
		if ($_FILES['image']['name']) {
			$result = Photo::getBase64();
			if (isset($result['error'])) {
				return $result['error'];
			}
			if (isset($result['photo'])) {
				$photo = $result['photo'];
			}
		}
		$token = md5($_POST['email'] . "918273645");
		$password = hash('whirlpool', $_POST['password']);
		$created_at = date("Y-m-d H:i:s");
		//строчка для автоматической активации - убрать
		$activated = 1;
		try {
			$link = self::getDB();
			//убрать активацию потом
			$sql = "INSERT INTO users (login, name, surname, password, email, token, photo, created_at, activated)
			VALUES (:login, :name, :surname, :password, :email, :token, :photo, :created_at, :activated)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':login', $_POST['login']);
			$sth->bindParam(':name', $_POST['name']);
			$sth->bindParam(':surname', $_POST['surname']);
			$sth->bindParam(':password', $password);
			$sth->bindParam(':email', $_POST['email']);
			$sth->bindParam(':token', $token);
			$sth->bindParam(':photo', $photo);
			$sth->bindParam(':created_at', $created_at);
			//строчка для автоматической активации - убрать
			$sth->bindParam(':activated', $activated);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		//$result = self::sendToken($_POST['login']);
		$result = true;
		if ($result) {
			return true;
		} else {
			return "Возникла ошибка при отправке на е-mail";
		}
	}

	public function login() //+
	{
		if (($validation = UserValidation::validateAuth()) !== true) {
			return $validation;
		}
		try {
			$link = self::getDB();
			$sql = "SELECT password, activated, id FROM users WHERE login=:login";
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
			if ($result['activated'] === '1') {
				$_SESSION['user'] = $_POST['login'];
				$_SESSION['user_id'] = $result['id'];
				return true;
			} else {
				return "Аккаунт не активирован";
			}
		} else {
			return "Неправильный пароль";
		}
	}

	public function activateAccount($id, $token) //+
	{
		try {
			$link = self::getDB();
			$sql = "SELECT token, activated FROM users WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		if (!($result) || $result['token'] !== $token) {
			return "Cсылка не активна";
		}
		if ($result['activated'] === '1') {
			return "Аккаунт уже активирован";
		}
		try {
			$sql = "UPDATE users SET activated = '1' WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $id);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		return true;
	}

	public function sendRecoveryLink() //+
	{
		if (($validation = UserValidation::checkEmailIsSet()) !== true) {
			return $validation;
		}
		if (($result_id = UserValidation::checkEmailExist($_POST['email'])) === false) {
			return "Пользователь не найден";
		}

		//проверка, отправлено ли такое письмо
		try {
			$link = self::getDB();
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
		if ($result) {
			return "Ссылка уже направлена";
		}

		//сохранение токена во временную таблицу
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

		//отправка письма
		$subject = "Camagru - Password Recovery";
		$message = "Для смены пароля пройдите по ссылке: " .
			self::ADDRESS . "/changepassword?token=" . $token;
		if (self::sendMail($_POST['email'], $subject, $message) === false) {
			return "Произошла ошибка при отправке письма";
		}
		return true;
	}

	public function recoveryLinkConfirmation()
	{
		if (isset($_GET['token'])) {
			try {
				$link = self::getDB();
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

	public function changePassword($user_id)
	{
		if (($message = UserValidation::validatePassword()) !== true) {
			return $message;
		}
		$new_password = hash('whirlpool', $_POST['password']);
		// проверка, что пароль не совпадает с предыдущим;
		try {
			$link = self::getDB();
			$sql = "SELECT password FROM users WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $user_id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		if ($new_password === $result['password']) {
			return "Пароль совпадает с текущим";
		}
		//обновление пароля
		try {
			$sql = "UPDATE users SET password=:password WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $user_id);
			$sth->bindParam(':password', $new_password);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}

		//удаление записи из таблицы reset_password
		try {
			$sql = "DELETE FROM reset_password WHERE user_id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $user_id);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		return "Ваш пароль успешно изменен";
	}
}