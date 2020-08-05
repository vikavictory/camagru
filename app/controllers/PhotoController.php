<?php

namespace app\controllers;

use app\Model;

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
	}
}