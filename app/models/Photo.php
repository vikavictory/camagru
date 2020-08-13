<?php

namespace app\models;
use app\Model;

class Photo extends Model
{
	public static function loadPhoto($source) {
		if (isset($_FILES['image'])) {
			$image = $_FILES['image'];
			$fileTmpName = $image['tmp_name'];
			$errorCode = $image['error'];
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
				$errorMessages = [
					UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
				];
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
				return (['error' => $outputMessage]);
			}

			$fi = finfo_open(FILEINFO_MIME_TYPE); // Создадим ресурс FileInfo
			$mime = (string)finfo_file($fi, $fileTmpName); // Получим MIME-тип
			if (strpos($mime, 'image') === false) {
				return (['error' => "Можно загружать только изображения."]);
			}
			$image = getimagesize($fileTmpName);
			$name = md5_file($fileTmpName);
			$extension = image_type_to_extension($image[2]); // Сгенерируем расширение файла на основе типа картинки
			if (!move_uploaded_file($fileTmpName, ROOT . $source . $name . $extension)) {
				return (['error' =>'При записи изображения на диск произошла ошибка.']);
			}
			return (['photoName' => $name . $extension] );
		}
	}


}