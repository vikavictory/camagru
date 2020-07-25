<?php

use app\DB;
require_once '../app/DB.php';

$db = new DB();
$query = $db::$db_connection->exec("DROP SCHEMA IF EXISTS `camagru`");
echo $query;