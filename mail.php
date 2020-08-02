<?php
date_default_timezone_set('Europe/Moscow');
ini_set("SMTP", "127.0.0.1");
ini_set("smtp_port", "25");

$to = 'sergius.didenko@yandex.ru';
$subject = "Camagru";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "Content-Transfer-Encoding: utf-8\r\n";
$headers .= "Reply-To: no-reply@gmail.com\r\n";
//$headers .= 'X-Mailer: PHP/' . phpversion();

$message = "hikugjhg";

$result = mail($to, $subject, $message, $headers);

echo "result : " . $result;
