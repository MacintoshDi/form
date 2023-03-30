<?php

// Подключаем файл с настройками базы данных
require_once 'config.php';

// Проверяем, что была отправлена форма и что все поля заполнены
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['rating']) && !empty($_POST['captcha'])) {

  // Проверяем правильность введенного значения в поле captcha
  if ($_POST['captcha'] == $_SESSION['captcha']) {

    // Создаем подключение к базе данных
    $conn = new mysqli($host, $username, $password, $database);

    // Проверяем, удалось ли подключиться к базе данных
    if ($conn->connect_error) {
      die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Защищаем данные, полученные из формы, от SQL-инъекций
    $name = $conn->real_escape_string($_POST['name']);
    $comment = $conn->real_escape_string($_POST['comment']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $photo = $conn->real_escape_string($_FILES['photo']['name']);

    // Создаем SQL-запрос для добавления комментария в базу данных
    $sql = "INSERT INTO comments (name, comment, rating, photo) VALUES ('$name', '$comment', '$rating', '$photo')";

    // Выполняем запрос
    if ($conn->query($sql) === TRUE) {
      // Выводим сообщение об успешном добавлении комментария
      echo "Комментарий успешно добавлен!";
    } else {
      // Выводим сообщение об ошибке при добавлении комментария
      echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    // Закрываем соединение с базой данных
    $conn->close();

  } else {
    echo "Введенный код с картинки неверный";
  }
}
