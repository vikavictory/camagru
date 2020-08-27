<?php

namespace app\models;

use app\Model;

class Comment extends Model
{
	public static function createComment() {
		try {
			$created_at = date("Y-m-d H:i:s");
			$photo_id = $_POST['photo_id'];
			$user_id = $_POST['user_id'];
			$comment_text = $_POST['comment'];
			//$photo_id = 4;
			//$user_id = 1;
			//$comment_text = "hello";
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
			$sql = "SELECT * FROM comments WHERE photo_id=:photo_id";
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

}