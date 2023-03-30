<?php
require_once('config.php');
require_once('captcha.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем входные данные от пользователя и очищаем их
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Проверяем CAPTCHA
    $response = verifyCaptcha($_POST['g-recaptcha-response']);
    if (!$response['success']) {
        die('Ошибка CAPTCHA: ' . $response['error-codes']);
    }

    // Подключаемся к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname='.$db_name, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Подготавливаем запрос с параметрами
    $stmt = $pdo->prepare("INSERT INTO comments (name, email, message) VALUES (:name, :email, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // Выполняем запрос
    $stmt->execute();
}
?>
