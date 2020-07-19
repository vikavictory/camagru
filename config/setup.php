<?php
//$link = mysqli_connect("127.0.0.1", "root", "root", "try");
//
//if (!$link) {
//	echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
//	echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
//	echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
//	exit;
//}
//
//echo "Соединение с MySQL установлено!" . PHP_EOL;
//echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;
//
//mysqli_close($link);
$mysqli = new mysqli("127.0.0.1", "root", "root", "try");

/* проверка соединения */
if ($mysqli->connect_errno) {
	printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
	exit();
}
else
	printf("Удалось подключиться\n");

if ($mysqli->query("USE try") === TRUE) {
	printf("Используется БД try.\n");
}
else
	printf("ОШИБКА - USE try.\n");

if ($result = $mysqli->query("SHOW tables")) {
	print_r($result);
}
else
	printf("ОШИБКА - SHOW tables.\n");

///* Создание таблицы не возвращает результирующего набора */
//if ($mysqli->query("SHOW TABLES") === TRUE) {
//	printf("Таблица myCity успешно создана.\n");
//}
//else
//	printf("Таблица myCity не создана.\n");
//
//
///* Select запросы возвращают результирующий набор */
//if ($result = $mysqli->query("SELECT Name FROM City LIMIT 10")) {
//	printf("Select вернул %d строк.\n", $result->num_rows);
//
//	/* очищаем результирующий набор */
//	$result->close();
//}
//
//
///* Если нужно извлечь большой объем данных, используем MYSQLI_USE_RESULT */
//if ($result = $mysqli->query("SELECT * FROM City", MYSQLI_USE_RESULT)) {
//
//	/* Важно заметить, что мы не можем вызывать функции, которые взаимодействуют
//	   с сервером, пока не закроем результирующий набор. Все подобные вызовы
//	   будут вызывать ошибку 'out of sync' */
//	if (!$mysqli->query("SET @a:='this will not work'")) {
//		printf("Ошибка: %s\n", $mysqli->error);
//	}
//	$result->close();
//}

$mysqli->close();
?>