<?php

namespace app\controllers;

use app\Model;
use app\models\Photo;
use app\models\User;
use app\models\Comment;
use app\models\Like;

class PhotoController extends Model
{
	private $DIR_PATH = 'app/views/photo/';

	public function gallery()
	{
		$result = Photo::getGallery();
		//self::debug($result);
		$pathView = 'app/views/index.php';
		require_once $pathView;
	}

	public function photo()
	{
		self::debug($_POST);
		self::debug($_FILES);
		if (isset($_FILES['image']) && $_POST['submit'] === "Download") {
			$result = Photo::getBase64();
			if (isset($result['error'])) {
				echo $result['error'];
			} else {
				$photo = $result['photo'];
				$result = Photo::saveToDB($photo, $_SESSION['user_id']);
			}
		}
		$pathView = 'app/views/photo/photo.php';
		require_once $pathView;
	}

	public function save()
	{
		if (isset($_POST['photo'])) {
			$result = Photo::PhotoValidation($_POST['photo']);
			self::debug($result);
			if (isset($result['error'])) {
				//здесь нужно отправить ошибку через ajax - как??
				echo $result['error'];
			} else {
				$result = Photo::saveToDB($_POST['photo'], $_SESSION['user_id']);
			}
		}
	}

	public function preview()
	{
		$pathView = 'app/views/photo/save.php';
		require_once $pathView;
	}

	public function getOnePhoto($photo_id)
	{
		if (isset($_POST['delete']) && isset($_POST['photo_id']) && isset($_POST['user_id'])) {
			//проверки всех удалений
			$result = Like::deleteAllLikesPhoto($_POST['photo_id']);
			$result = Comment::deleteAllCommentsPhoto($_POST['photo_id']);
			$result = Photo::deletePhoto($_POST['photo_id'], $_POST['user_id']);
			if ($result) {
				header('Location: /user/' . $_SESSION['user']);
			}
		} else {
			//сделать обработку, что фото не существует
			$photo = Photo::getPhoto($photo_id);
			if ($photo) {
				$login = User::getUserLogin($photo['user_id']);
				// сделать обработку ошибок
				if ($login) {
					$photo['login'] = $login['login'];
				}
				$pathView = $this->DIR_PATH . 'onephoto.php';
				require_once $pathView;
			} else {
				self::ErrorPage404();
			}
		}
	}

	public function newcomment() {
		$check = Comment::checkDataForNewComment();
		if ($check["result"] === false){
			echo json_encode($check);
		} else {
			$result = Comment::createComment();
			if ($result["result"] === true) {
				Comment::sendCommentNotification($result["comment_id"]);
				echo json_encode(["result" => true, "message" => "Комментарий успешно добавлен"]);
			} else {
				echo json_encode(["result" => false, "message" => "Не удалось добавить комментарий"]);
			}
		}
	}

	public function getcomments() {
		$check = Comment::checkDataForGetComments();
		$photo_id = $_POST['photo_id'];
		if ($check["result"] === false){
			echo json_encode($check);
		} else {
			$result = Comment::getComments($photo_id);
			echo json_encode($result);
		}
	}

	public function deletecomment() {
		$check = Comment::checkDataForDeleteComment(); // передать id комментария и id автора комментария, проверить что совпадают
		var_dump($_POST);
		$comment_id = $_POST['comment_id'];
		if ($check["result"] === false){
			echo json_encode($check);
		} else {
			$result = Comment::deleteComment($comment_id);
			echo json_encode($result);
		}
	}

	public function getlikes() {
		$check = Like::checkDataForLikesCount();
		$photo_id = $_POST['photo_id'];
		if ($check["result"] === false){
			echo json_encode($check);
		} else {
			$result = Like::getLikesCount($photo_id);
			if (isset($_SESSION["user"]) && isset($_SESSION["user_id"])) {
				$result["usersLike"] = Like::checkIfLikeIs($photo_id, $_SESSION["user_id"]);
			} else {
				$result["usersLike"] = false;
			}
			echo json_encode($result);
		}
	}

	public function changelike() {
		$check = Like::checkDataForLikesChanging();
		if ($check["result"] === false){
			echo json_encode($check);
		} else {
			$photo_id = $_POST['photo_id'];
			$user_id = $_POST['user_id'];
			$result = Like::checkIfLikeIs($photo_id, $user_id);
			if ($result === true) {
				Like::deleteLike($photo_id, $user_id);
				$result = ["message" => "Лайк удален"];
			} else {
				Like::newLike($photo_id, $user_id);
				$result = ["message" => "Лайк добавлен"];
			}
			echo json_encode($result);
		}
	}

	private function ErrorPage404()
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
	}
}