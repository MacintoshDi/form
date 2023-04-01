<?php
session_start();
$___DEBUG = 0;

// Подключаем файл с настройками базы данных
require_once 'config.php';


// File functions.php
function getRandomFileName($path)
{
  $path = $path ? $path . '/' : '';
  do {
      $name = md5(microtime() . rand(0, 9999));
      $file = $path . $name;
  } while (file_exists($file));

  return $name;
}

// Проверяем, что была отправлена форма и что все поля заполнены
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['rating']) && !empty($_POST['captcha'])) {

  // Проверяем правильность введенного значения в поле captcha
  if ($_POST['captcha'] == $_SESSION['captcha']) {

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

// Получаем нужные элементы массива "image"
$fileTmpName = $_FILES['image']['tmp_name'];
$errorCode = $_FILES['image']['error'];
// Проверим на ошибки
if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
    // Массив с названиями ошибок
    $errorMessages = [
      UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
      UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
      UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
      UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
      UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
      UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
      UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
    ];
    // Зададим неизвестную ошибку
    $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
    // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
    $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
    // Выведем название ошибки
    die($outputMessage);
} else {
    // Создадим ресурс FileInfo
    $fi = finfo_open(FILEINFO_MIME_TYPE);
    // Получим MIME-тип
    $mime = (string) finfo_file($fi, $fileTmpName);
    // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
    if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');

    // Результат функции запишем в переменную
    $image = getimagesize($fileTmpName);

    // Зададим ограничения для картинок
    $limitBytes  = 1024 * 1024 * 5;
    $limitWidth  = 1280;
    $limitHeight = 768;

    // Проверим нужные параметры
    if (filesize($fileTmpName) > $limitBytes) die('Размер изображения не должен превышать 5 Мбайт.');
    if ($image[1] > $limitHeight)             die('Высота изображения не должна превышать 768 точек.');
    if ($image[0] > $limitWidth)              die('Ширина изображения не должна превышать 1280 точек.');

    // Сгенерируем новое имя файла через функцию getRandomFileName()
    $name = getRandomFileName($fileTmpName);

    // Сгенерируем расширение файла на основе типа картинки
    $extension = image_type_to_extension($image[2]);

    // Сократим .jpeg до .jpg
    $format = str_replace('jpeg', 'jpg', $extension);

    // Переместим картинку с новым именем и расширением в папку /upload
    if (!move_uploaded_file($fileTmpName, __DIR__ . '/img/' . $name . $format)) {
        die('При записи изображения на диск произошла ошибка.');
    }
    
    $photo = $name.$format;
    echo 'Картинка успешно загружена! ';
  }
};


    // // Создаем подключение к базе данных
    // $conn = new mysqli($host, $username, $password, $database);

    // // Проверяем, удалось ли подключиться к базе данных
    // if ($conn->connect_error) {
    //   die("Ошибка подключения к базе данных: " . $conn->connect_error);
    // }

    // // Защищаем данные, полученные из формы, от SQL-инъекций
    // $name = $conn->real_escape_string($_POST['name']);
    // $comment = $conn->real_escape_string($_POST['comment']);
    // $rating = $conn->real_escape_string($_POST['rating']);
    // $photo = $conn->real_escape_string($_FILES['photo']['name']);

    // Создаем SQL-запрос для добавления комментария в базу данных
    

    // // Выполняем запрос
    // if ($conn->query($sql) === TRUE) {
    //   // Выводим сообщение об успешном добавлении комментария
    //   echo "Комментарий успешно добавлен!";
    // } else {
    //   // Выводим сообщение об ошибке при добавлении комментария
    //   echo "Ошибка: " . $sql . "<br>" . $conn->error;
    // }

    // // Закрываем соединение с базой данных
    // $conn->close();
    $name = filter_input(INPUT_POST, 'name');
    $comment = filter_input(INPUT_POST, 'comment');
    $rating = filter_input(INPUT_POST, 'rating');
    //$photo = filter_input(INPUT_POST, 'photo');
    //$photo = '';
    $sql = "INSERT INTO comments (name, comment, rating, photo) VALUES ('$name', '$comment', '$rating', '$photo')";
    
    
    $STMT = $pdo->prepare($sql);
    $result = $STMT->execute();
    
    if ($result) echo "С великим уважением выражаем благодарность за Ваш отзыв. Ваше мнение для нас очень важно, и мы ценим то, что вы нашли время поделиться им с нами. Надеемся, что наша работа продолжит оправдывать Ваши ожидания, и мы всегда будем рады приветствовать Вас снова!";
    

  } else {
    echo "Введенный код с картинки неверный";
  }
}


if ($___DEBUG == 1){
  echo "<pre><code>";
print_r($_FILES);
echo "</code></pre><hr/>";
echo "<pre><code>";
print_r($_POST);
echo "</code></pre><hr/>";
echo "<pre><code>";
print_r($_SESSION);
echo "</code></pre><hr/>";
  echo "<pre><code>";
  print_r($sql);
  echo "</code></pre><hr/>";
  print_r($result);

}

// Получаем первые 5 комментариев
$query = "SELECT * FROM comments LIMIT 5";
$result = mysqli_query($conn, $query);

// Отображаем комментарии
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='comment'>";
    echo "<p><strong>" . $row['name'] . "</strong></p>";
    echo "<p>" . $row['message'] . "</p>";
    echo "</div>";
}

// Если есть больше комментариев, отображаем кнопку "Больше комментариев"
$count_query = "SELECT COUNT(*) FROM comments";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_row($count_result);
if ($count_row[0] > 5) {
    echo "<button id='load-more-comments'>Больше комментариев</button>";
}
