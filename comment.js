const form = document.getElementById('free_consultation');
const commentList = document.getElementById('comment-list');
const loadMoreButton = document.getElementById('load-more');

// Функция для отправки данных на сервер
function sendForm(event) {
  event.preventDefault();

  // Проверяем введенные данные
  const name = document.getElementById('name').value;
  const comment = document.getElementById('comment').value;
  const rating = document.getElementById('rating').value;
  const captcha = document.getElementById('captcha').value;
  const csrfToken = document.getElementById('csrf_token').value;

  const captchaImage = document.getElementById('captcha');
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
}
