<?php

//use app\DB;
require_once '../app/DB.php';

require_once('database.php');
$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('database.sql');
$query = $db->exec($sql);
echo $query;






