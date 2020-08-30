<?php

namespace app\controllers;

use app\Model;
use app\models\Photo;
use app\models\User;
use app\models\Comment;

class PhotoController extends Model
{
	private $DIR_PATH = 'app/views/photo/';

	function debug($str)
	{
		echo '<pre>';
		var_dump($str);
		echo '</pre>';
	}

	public function gallery()
	{
		$result = Photo::getGallery();
		$pathView = 'app/views/index.php';
		require_once $pathView;
	}

	public function photo()
	{
		if (isset($_FILES['image'])) {
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
			//$pathView = 'app/views/index.php';
			//require_once $pathView;
			//$this->debug($_POST);
			//$this->debug($_POST['photo']);
			$result = Photo::PhotoValidation($_POST['photo']);
			if (isset($result['error'])) {
				//здесь нужно отправить ошибку через ajax
				echo $result['error'];
			} else {
				$result = Photo::saveToDB($_POST['photo'], $_SESSION['user_id']);
			}
		}
	}

	public function preview()
	{
		$this->debug($_SESSION);
		$this->debug($_POST);
		$pathView = 'app/views/photo/save.php';
		require_once $pathView;
	}

	public function getOnePhoto($photo_id)
	{
		if (isset($_POST['delete'])) {
			//передавать ещё id пользователя, чтобы убедиться, что это его фото
			$result = Photo::deletePhoto($_POST['photo_id']);
			header('Location: /user/' . $_SESSION['user']);
			//echo "Фото удалено";
		} else {
			//сделать обработку, что фото не существует
			$photo = Photo::getPhoto($photo_id);
			if ($photo) {
				$login = User::getUserLogin($photo['user_id']);
				// сделать обработку ошибок
				if ($login) {
					$photo['login'] = $login['login'];
				}
				//$this->debug($photo);
				$pathView = $this->DIR_PATH . 'onephoto.php';
				require_once $pathView;
			} else {
				self::ErrorPage404();
			}
		}
	}

	public function newcomment() {
		//$this->debug($_POST);
		//сделать проверку, что пользователь авторизованн
		//текст комментария
		//что существует фотография и пользователь
		if (isset($_POST['comment'])) {
			$result = Comment::createComment();
		}
	}

	public function getcomments() {
		$result = Comment::getComments(4);
		echo json_encode($result);
	}

	private function ErrorPage404()
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
	}
}