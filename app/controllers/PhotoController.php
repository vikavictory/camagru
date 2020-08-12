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
		echo $_SERVER['REMOTE_ADDR'];
		//var_dump($_FILES);
		if (isset($_FILES['image'])) {
			$image = $_FILES['image'];
			// Получаем нужные элементы массива "image"
			$fileTmpName = $_FILES['image']['tmp_name'];
			$errorCode = $_FILES['image']['error'];
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
				// Массив с названиями ошибок
				$errorMessages = [
					UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
				];
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
				// Выведем название ошибки
				die($outputMessage);
			} else {
				echo 'Ошибок нет.';
			}
			// Создадим ресурс FileInfo
			$fi = finfo_open(FILEINFO_MIME_TYPE);

			// Получим MIME-тип
			$mime = (string)finfo_file($fi, $fileTmpName);

			// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
			if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');

			$image = getimagesize($fileTmpName);
			$name = md5_file($fileTmpName);

			// Сгенерируем расширение файла на основе типа картинки
			$extension = image_type_to_extension($image[2]);
			if (!move_uploaded_file($fileTmpName, ROOT . '/storage/' . $name . $extension)) {
				die('При записи изображения на диск произошла ошибка.');
			}
			echo 'Картинка успешно загружена!';
		}
	}

	public function try() {
		var_dump($_POST);
	}
}