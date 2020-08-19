<?php

namespace app\controllers;

use app\Model;
use app\models\Photo;
use app\models\User;

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
		//$this->debug($result);
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
				//$_SESSION['photo'] = $photo;
				//header('Location: /preview');


				//if ( $curl = curl_init() ) {
				//	curl_setopt($curl, CURLOPT_URL, 'http://localhost/preview');
				//	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				//	curl_setopt($curl, CURLOPT_POST, true);
				//	curl_setopt($curl, CURLOPT_POSTFIELDS, "a=4&b=7");
				//	$out = curl_exec($curl);
				//	echo $out;
				//	curl_close($curl);
				//}


			}
		}
		$pathView = 'app/views/photo/photo.php';
		require_once $pathView;
	}

	public function save()
	{
		if (isset($_POST['photo'])) {
			$pathView = 'app/views/index.php';
			require_once $pathView;
			$this->debug($_POST);
			//$this->debug($_POST['photo']);
			$result = Photo::saveToDB($_POST['photo'], $_SESSION['user_id']);
		}
	}

	public function preview()
	{
		$this->debug($_SESSION);
		$this->debug($_POST);
		$pathView = 'app/views/photo/save.php';
		require_once $pathView;
		//$this->debug($_POST);
		//$this->debug($_POST['photo']);
		//$result = Photo::saveToDB($_POST['photo'], $_SESSION['user_id']);
		//header('Location: /user/' . $_SESSION['user']);
	}

	public function getOnePhoto($photo_id) {
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