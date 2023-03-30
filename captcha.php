<?php
session_start();

// Создаем изображение капчи
$width = 200;
$height = 50;
$image = imagecreatetruecolor($width, $height);

// Генерируем случайный цвет для фона
$bg_color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));

// Заливаем фон
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

// Генерируем случайные символы для капчи
$alphabet = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
$length = rand(4, 6);
$captcha_text = '';
for ($i = 0; $i < $length; $i++) {
    $captcha_text .= $alphabet[rand(0, strlen($alphabet) - 1)];
}

// Сохраняем символы капчи в сессии
$_SESSION['captcha'] = $captcha_text;

// Наносим символы на изображение
$text_color = imagecolorallocate($image, 0, 0, 0);
$font_size = 30;
$x = 20;
$y = 40;
for ($i = 0; $i < $length; $i++) {
    $angle = rand(-10, 10);
    imagettftext($image, $font_size, $angle, $x, $y, $text_color, 'arial.ttf', $captcha_text[$i]);
    $x += rand(30, 40);
}

// Добавляем шум на изображение
$noise_color = imagecolorallocate($image, 100, 100, 100);
for ($i = 0; $i < 1000; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise_color);
}

// Выводим изображение
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
