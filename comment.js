const form = document.getElementById('free_consultation');
const commentList = document.getElementById('comment-list');
const loadMoreButton = document.getElementById('load-more');

// Функция для отправки данных на сервер
function sendForm(event) {
  event.preventDefault();

  // Проверяем введенные данные
  const name = document.getElementById('name').value.trim();
  const comment = document.getElementById('comment').value.trim();
  const rating = document.getElementById('rating').value;
  const captcha = document.getElementById('captcha').value.trim();
  const csrfToken = document.getElementById('csrf_token').value.trim();

  // Проверяем заполнение обязательных полей
  if (!name || !comment || !captcha) {
    alert('Не заполнены обязательные поля!');
    return;
  }

  const captchaImage = document.getElementById('captcha-img');
  captchaImage.onload = function() {
    // Дополнительные настройки для отображения капчи
  };
  captchaImage.src = 'captcha.php?' + Date.now();

  // Отправляем данные на сервер
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'comment.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Если данные были успешно отправлены, обновляем список комментариев
      updateCommentList();
    }
  };
  xhr.send(`name=${name}&comment=${comment}&rating=${rating}&captcha=${captcha}&csrf_token=${csrfToken}`);
}
