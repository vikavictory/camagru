<?php

namespace app\models;

use app\Model;
use app\models\User;
use app\models\Photo;

class Comment extends Model
{
	public static function createComment() {
		try {
			$created_at = date("Y-m-d H:i:s");
			$photo_id = $_POST['photo_id'];
			$user_id = $_POST['user_id'];
			$comment_text = $_POST['comment'];
			$link = self::getDB();
			$sql = "INSERT INTO comments (photo_id, user_id, comment_text, created_at)
			VALUES (:photo_id, :user_id, :comment_text, :created_at)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':comment_text', $comment_text);
			$sth->bindParam(':created_at', $created_at);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		return true;
	}

	public static function getComments($photo_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT photo_id, user_id, comment_text, comments.created_at, users.login FROM comments 
					INNER JOIN users ON comments.user_id = users.id
					WHERE photo_id=:photo_id
					ORDER BY comments.created_at";
			$sth = $link->prepare($sql);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
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

	public static function checkDataForNewComment() {
		if (!isset($_SESSION["user"]) && !isset($_SESSION["user_id"])) {
			return ["result" => false, "message" => "Пользователь не авторизирован"];
		}
		if (!isset($_POST["comment"]) || $_POST["comment"] === "") {
			return ["result" => false, "message" => "Отсутствует текст комментария"];
		}
		if (!isset($_POST["photo_id"]) || $_POST["photo_id"] === "") {
			return ["result" => false, "message" => "В запросе отсутствует id-фотографии"];
		}
		if (!isset($_POST["user_id"]) || $_POST["user_id"] === "") {
			return ["result" => false, "message" => "В запросе отсутствует id-пользователя"];
		}
		if ($_SESSION["user_id"] !== $_POST["user_id"]) {
			return ["result" => false, "message" => "Пользователь не соответствует авторизированному пользователю"];
		}
		if (!(Photo::getPhoto($_POST["photo_id"]))) {
			return ["result" => false, "message" => "Фото не найдено"];
		}
		if (!(User::getUserLogin($_POST["user_id"]))) {
			return ["result" => false, "message" => "Пользователь не найден"];
		}
		return ["result" => true];
	}

	public static function checkDataForGetComments() {
		if (!isset($_POST["photo_id"]) || $_POST["photo_id"] === "") {
			return ["result" => false, "message" => "В запросе отсутствует id-фотографии"];
		}
		if (!(Photo::getPhoto($_POST["photo_id"]))) {
			return ["result" => false, "message" => "Фото не найдено"];
		}
		return ["result" => true];
	}


	public static function deleteComment($comment_id) {
//		try {
//			$link = self::getDB();
//			$sql = "SELECT * FROM comments WHERE photo_id=:photo_id";
//			$sth = $link->prepare($sql);
//			$sth->bindParam(':photo_id', $photo_id);
//			$sth->execute();
//			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
//		} catch( PDOException $e) {
//			$error = $e->getMessage();
//		} catch( Exception $e) {
//			$error = $e->getMessage();
//		}
//		if ($error) {
//			return false;
//		}
//		return $result;
	}

}