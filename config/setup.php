<?php

require_once 'database.php';
$db = new PDO('mysql:host=127.0.0.1', $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('database.sql');
$query = $db->exec($sql);
//перенести сюда создание админа
echo $query;






