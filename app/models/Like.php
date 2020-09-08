<?php


namespace app\models;
use app\Model;

class Like extends Model
{
	public static function checkIfLikeIs($photo_id, $user_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT id FROM likes
					WHERE user_id=:user_id AND photo_id=:photo_id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->execute();
			$result = $sth->rowCount(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function newLike($photo_id, $user_id) {
		$created_at = date("Y-m-d H:i:s");
		try {
			$link = self::getDB();
			$sql = "INSERT INTO likes (user_id, photo_id, created_at)
			VALUES (:user_id, :photo_id, :created_at)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->bindParam(':created_at', $created_at);
			$sth->execute();
		} catch(PDOException $e) {
			return $e->getMessage();
		} catch(Exception $e) {
			return $e->getMessage();
		}
		return true;
	}

	public static function getLikesCount($photo_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT id FROM likes
					WHERE photo_id=:photo_id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->execute();
			$result = $sth->rowCount(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return ['likesCount' => $result];
	}

	public static function deleteLike($photo_id, $user_id) {
		try {
			$link = self::getDB();
			$sql = "DELETE FROM likes
			WHERE user_id=:user_id AND photo_id=:photo_id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':photo_id', $photo_id);
			$sth->execute();
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return true;
	}

}