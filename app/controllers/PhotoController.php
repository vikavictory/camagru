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
			//$this->debug($_POST);
			//$this->debug($_POST['photo']);
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
		//сделать проверку, что пользователь авторизованн
		//текст комментария
		//что существует фотография и пользователь
		if (isset($_POST['comment'])) {
			$result = Comment::createComment();
			echo "OK";
		}
	}

	public function getcomments() {
		if (isset($_POST['photo_id'])) {
			//проверить есть ли вообще такое фото
			$photo_id = $_POST['photo_id'];
			$result = Comment::getComments($photo_id);
			//self::debug($result);
			echo json_encode($result);
		}
	}

	public function getlikes() {
		if (isset($_POST['photo_id'])) {
			//проверить есть ли вообще такое фото
			$photo_id = $_POST['photo_id'];
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
		if (isset($_SESSION["user"]) && isset($_SESSION["user_id"])) {
			if (isset($_POST['photo_id']) && isset($_POST['user_id'])) {
				//проверить есть ли вообще такое фото и пользователь;
				$photo_id = $_POST['photo_id'];
				$user_id = $_POST['user_id'];
				$result = Like::checkIfLikeIs($photo_id, $user_id);
				if ($result === true) {
					Like::deleteLike($photo_id, $user_id);
					echo "delete";
				} else {
					Like::newLike($photo_id, $user_id);
					echo "new";
				}
			}
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