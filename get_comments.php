<?php
session_start();

// Получаем список комментариев
$comments = $_SESSION['comments'] ?? [];

// Выводим список комментариев
foreach ($comments as $comment) {
  echo '<li>';
  echo '<div class="comment">';
  echo '<div class="comment__author">' . htmlspecialchars($comment['name']) . '</div>';
  echo '<div class="comment__text">' . htmlspecialchars($comment['comment']) . '</div>';
  echo '<div class="comment__rating">' . htmlspecialchars($comment['rating']) . '</div>';
  if (!empty($comment['photo'])) {
    echo '<div class="comment__photo"><img src="' . htmlspecialchars($comment['photo']) . '"></div>';
  }
  echo '</div>';
  echo '</li>';
}
