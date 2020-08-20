<?php

namespace app\models;
use app\Model;

class Photo extends Model
{
//	public static function loadPhoto($source) {
//		if (isset($_FILES['image'])) {
//			$image = $_FILES['image'];
//			$fileTmpName = $image['tmp_name'];
//			$errorCode = $image['error'];
//			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
//				$errorMessages = [
//					UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
//					UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
//					UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
//					UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
//					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
//					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
//					UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
//				];
//				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
//				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
//				return (['error' => $outputMessage]);
//			}
//
//			$fi = finfo_open(FILEINFO_MIME_TYPE); // Создадим ресурс FileInfo
//			$mime = (string)finfo_file($fi, $fileTmpName); // Получим MIME-тип
//			if (strpos($mime, 'image') === false) {
//				return (['error' => "Можно загружать только изображения."]);
//			}
//			$image = getimagesize($fileTmpName);
//			$name = md5_file($fileTmpName);
//			$extension = image_type_to_extension($image[2]); // Сгенерируем расширение файла на основе типа картинки
//			if (!move_uploaded_file($fileTmpName, ROOT . $source . $name . $extension)) {
//				return (['error' =>'При записи изображения на диск произошла ошибка.']);
//			}
//			return (['photoName' => $name . $extension] );
//		}
//	}
//
//	public static function savePhoto($source) {
//		if (isset($_FILES['image'])) {
//			$image = $_FILES['image'];
//			$fileTmpName = $image['tmp_name'];
//			$errorCode = $image['error'];
//			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
//				$errorMessages = [
//					UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
//					UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
//					UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
//					UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
//					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
//					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
//					UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
//				];
//				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
//				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
//				return (['error' => $outputMessage]);
//			}
//			$fi = finfo_open(FILEINFO_MIME_TYPE); // Создадим ресурс FileInfo
//			$mime = (string)finfo_file($fi, $fileTmpName); // Получим MIME-тип
//			if (strpos($mime, 'image') === false) {
//				return (['error' => "Можно загружать только изображения."]);
//			}
//			$data = file_get_contents($fileTmpName);
//			return (['photoName' => $data]);
//		}
//	}

	public static function getBase64() {
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
			$data = file_get_contents($fileTmpName);
			//сделать определение формата картинки
			$result = "data:image/png;base64," . base64_encode($data);
			return (['photo' => $result]);
		}
	}

	public static function saveToDB($photo, $user_id) {
		$created_at = date("Y-m-d H:i:s");
		try {
			$link = self::getDB();
			$sql = "INSERT INTO photos (user_id, created_at, photo)
			VALUES (:user_id, :created_at, :photo)";
			$sth = $link->prepare($sql);
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':photo', $photo);
			$sth->bindParam(':created_at', $created_at);
			$sth->execute();
		} catch(PDOException $e) {
			return $e->getMessage();
		} catch(Exception $e) {
			return $e->getMessage();
		}
		return true;
	}

	public static function getAllGallery() {
		// сделать, чтобы выдавало группами
		// сделать нормальную обработку ошибок
		try {
			$link = self::getDB();
			$sql = "SELECT id, photo FROM photos
					ORDER BY created_at";
			$sth = $link->prepare($sql);
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;
	}

	public static function getGallery() {

		//вынести обработку get_запроса и подавать в функцию номер страницы
		//получить общее количество фото
		//определить сколько всего страниц должно быть
		$photoCount = self::getPhotoCount();
		$pageCount = ceil($photoCount / 5);
		$from = 0;

		//получить get-запрос
		//проверить, что число
		//проверить, что входит в диапазон
		//как обрабатывать первую страничку - ??????

		if (isset($_GET['page'])) {
			$pageNumber = $_GET['page'];
			//обработать, что число
			if (1 <= $pageNumber && $pageNumber <= $pageCount) {

				$from += 5 * ($pageNumber - 1);
			}
			else {
				//подумать как нормально вернуть ошибки
				return false;
			}
		}

		try {
			$link = self::getDB();
			$sql = "SELECT id, photo FROM photos
					ORDER BY created_at
					LIMIT " . $from . ", 5";
			$sth = $link->prepare($sql);
			$sth->bindParam(':from', $from);
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;
	}

	public static function getUserPhoto($user_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT id, photo FROM photos WHERE user_id=:user_id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':user_id', $user_id);
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;
	}

	public static function getPhoto($photo_id) {
		try {
			$link = self::getDB();
			$sql = "SELECT user_id, photo, description, created_at FROM photos WHERE id=:id";
			$sth = $link->prepare($sql);
			$sth->bindParam(':id', $photo_id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;

	}

	public static function getPhotoCount() {
		try {
			$link = self::getDB();
			$sql = "SELECT id FROM photos";
			$sth = $link->prepare($sql);
			$sth->execute();
			$result = $sth->rowCount(\PDO::FETCH_ASSOC);
		} catch( PDOException $e) {
			$error = $e->getMessage();
		} catch( Exception $e) {
			$error = $e->getMessage();
		}
		if ($error) {
			return false;
		}
		return $result;
	}

}