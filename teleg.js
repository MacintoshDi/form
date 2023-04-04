(function ($) {
  $(".tg-form").submit(function (event) {
    event.preventDefault();

    // Сообщения формы
    let successSendText = "Сообщение успешно отправлено!";
    let errorSendText = "Сообщение не отправлено. Попробуйте еще раз!";
    let requiredFieldsText = "Не заполнены обязательные поля!";

    // Сохраняем в переменную класс с параграфом для вывода сообщений об отправке
    let message = $(this).find(".tg-form__request");

    let form = $("#" + $(this).attr("id"))[0];
    let fd = new FormData(form);
    $.ajax({
      url: "/telegramform/php/send-message-to-telegram.php",
      type: "POST",
      data: fd,
      processData: false,
      contentType: false,
      beforeSend: () => {
        // $(".preloader").addClass("preloader_active");
      },
      success: function success(res) {
        // $(".preloader").removeClass("preloader_active");

        // Посмотреть на статус ответа, если ошибка
        console.log(res);
        let respond = $.parseJSON(res);

        if (respond === "SUCCESS") {
          message.text(successSendText).css("color", "#5da827");
          setTimeout(() => {
            message.text("");
          }, 4000);
        } else if (respond === "NOTVALID") {
          message.text(requiredFieldsText).css("color", "#ef5152");
          setTimeout(() => {
            message.text("");
          }, 3000);
        } else {
          message.text(errorSendText).css("color", "#ef5152");
          setTimeout(() => {
            message.text("");
          }, 4000);
        }
      }
    });
  });
})(jQuery);
