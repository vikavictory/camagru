<?php
$DB_NAME = "camagru";


$db = new DB();
$db->
$mysqli = new mysqli("127.0.0.1", "root", "root", "try");

// подключение
if ($mysqli->connect_errno) {
	printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
	exit();
}
else
	printf("Удалось подключиться\n");

//создание БД
if ($mysqli->query("CREATE DATABASE IF NOT EXISTS " . $DB_NAME) === TRUE) {
	printf("Создана БД " . $DB_NAME . PHP_EOL);
}

//использование базы данных
if ($mysqli->query("USE " . $DB_NAME) === TRUE) {
	printf("Используется БД " . $DB_NAME . PHP_EOL);
}
else
	printf("ОШИБКА: " . $mysqli->error . PHP_EOL);

//создание таблицы
if ($result = $mysqli->query("CREATE TABLE ")) {
	print_r($result);
}
else
	printf("ОШИБКА: " . $mysqli->error . PHP_EOL);

if ($mysqli->query("INSERT users(login) VALUES ('user1') ") === TRUE) {
	print_r("ОК");
}
else
	printf("ОШИБКА: " . $mysqli->error . PHP_EOL);

$mysqli->close();
