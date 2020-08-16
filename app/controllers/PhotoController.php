<?php

namespace app\controllers;

use app\Model;
use app\models\Photo;

class PhotoController extends Model
{
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
		$pathView = 'app/views/photo/photo.php';
		require_once $pathView;
		if (isset($_FILES['image'])) {
			$result = Photo::getBase64();
			if (isset($result['error'])) {
				echo $result['error'];
			} else {
				$photo = $result['photoName'];
				$result = Photo::saveToDB($photo, $_SESSION['user_id']);
			}
		}
	}

	public function save()
	{

		if (isset($_POST['photo'])) {
			$pathView = 'app/views/index.php';
			require_once $pathView;
			$this->debug($_POST);
			$photo = explode('d', $_POST['photo'], 3);
			//$this->debug($_POST['photo']);
			$result = Photo::saveToDB($_POST['photo'], $_SESSION['user_id']);
		}
	}
}