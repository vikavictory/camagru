<?php

namespace app\controllers;

use app\Model;
use app\models\Photo;

class PhotoController extends Model
{
	public function gallery()
	{
		$pathView = 'app/views/index.php';
		require_once $pathView;
	}

	public function photo()
	{
		$pathView = 'app/views/photo/photo.php';
		require_once $pathView;
		if (isset($_FILES['image'])) {
			Photo::loadPhoto('/storage/');
		}
	}

	public function save()
	{

	}

	public function try() {
		var_dump($_POST);
	}
}