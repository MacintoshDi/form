<?php
include 'functions.php'; // Подключаем файл с функциями для работы с комментариями

$offset = $_GET['offset']; // Получаем смещение (сколько комментариев уже отображено)
$comments = get_comments($offset, 5); // Получаем следующие 5 комментариев

echo json_encode($comments); // Возвращаем комментарии в формате JSON
?>
