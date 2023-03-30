<?php
define('DB_HOST', 'localhost'); // адрес сервера базы данных
define('DB_NAME', 'ch7af6ded2_comment'); // имя базы данных
define('DB_USER', 'ch7af6ded2_comment'); // имя пользователя базы данных
define('DB_PASS', ''); // пароль пользователя базы данных

// Подключаемся к базе данных MySQL
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
?>
