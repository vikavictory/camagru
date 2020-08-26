<?php

namespace app\models;

use app\Model;

class Сomment extends Model
{
	public static function createComment() {
		try {
			$created_at = date("Y-m-d H:i:s");
			$link = self::getDB();
			$sql = "INSERT INTO comments (photo_id, user_id, comment_text, created_at)
			VALUES (:photo_id, :user_id, :comment_text, :created_at)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':photo_id', $);
			$sth->bindParam(':user_id', $);
			$sth->bindParam(':comment_text', $);
			$sth->bindParam(':created_at', $created_at);
			$sth->execute();
		} catch( PDOException $e) {
			return $e->getMessage();
		} catch( Exception $e) {
			return $e->getMessage();
		}
	}


}