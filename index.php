<?php
use app\Model;
use app\Router;

define('ROOT', dirname(__FILE__));

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class) . '.php';
    if (file_exists($path))
		require $path;
});

session_start();
//$db = new DB();

$router = new Router();
$router->start();

