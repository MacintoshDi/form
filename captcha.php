<?php
session_start();

$width = 200;
$height = 50;

$image = imagecreatetruecolor($width, $height);

$bg_color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

$alphabet = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
$length = rand(4, 6);
$captcha_text = '';
for ($i = 0; $i < $length; $i++) {
    $char = mb_chr(rand(97, 122), 'UTF-8');
    $captcha_text .= $char;
}

$_SESSION['captcha'] = $captcha_text;

$text_color = imagecolorallocate($image, 0, 0, 0);
$font_size = 30;
$x = 20;
$y = 40;
$font_file = 'arial.ttf';
if (file_exists($font_file)) {
    for ($i = 0; $i < $length; $i++) {
        $angle = rand(-10, 10);
        imagettftext($image, $font_size, $angle, $x, $y, $text_color, $font_file, $captcha_text[$i]);
        $x += rand(30, 40);
    }
}

$noise_color = imagecolorallocate($image, 100, 100, 100);
for ($i = 0; $i < 1000; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise_color);
}

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>

