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
			$result = $link->lastInsertId();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
		return ["result" => true, "comment_id" => $result];
	}

	public static function getComments($photo_id) {
		$error = ""; // для windows
		try {
			$link = self::getDB();
			$sql = "SELECT comments.id, photo_id, user_id, comment_text, comments.created_at, users.login FROM comments 
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

	public static function getOneComment($comment_id) {
		$error = ""; // для windows
		try {
			$link = self::getDB();
			$sql = "SELECT * FROM comments 
					WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $comment_id);
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

	public static function checkDataForDeleteComment() {
		return ["result" => true];
	}

	public static function deleteComment($comment_id) {
		try {
			$link = self::getDB();
			$sql = "DELETE FROM comments WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $comment_id);
			$sth->execute();
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return ["result" => "Произошла ошибка при удалении комментария"];
		}
		return ["result" => true];
	}


	// оповещение о комментарии;

	public static function sendCommentNotification($comment_id)
	{
		$commentData = Comment::getOneComment($comment_id);
		$recipientId = Photo::getPhotoOwner($commentData["photo_id"]);
		$recipientData = User::getRecipientInformation($recipientId["user_id"]); //получить почту и проверить включены ли комменты
		$commentator = User::getUserLogin($commentData["user_id"]);

		var_dump($commentData);
		var_dump($recipientData);

		if ($recipientData["notification"] === "1") {
			$subject = "Camagru - Новый комментарий";

			$message = "Пользователь " . $commentator["login"] . " оставил вам новый комментарий под фотографией " .
				self::ADDRESS . "/photo/" . $commentData["photo_id"];

			if (self::sendMail($recipientData['email'], $subject, $message) === false) {
				return "Произошла ошибка при отправке письма";
			}
			return true;
		}

	}


		//получить id-фото -> определить id владельца фото;
		//проверить, что включены оповещения у пользователя;
		//отправить след инфу:
		// -> почта владельца фото
		// -> login комментатора +
		// -> ссылка на фото id-фото +
		// -> время создания комментария +


}