$(document).ready(function () {
  $("#contactForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "enviarCorreo.php",
      data: $(this).serialize(),
      success: function (response) {
        $("#responseMessage").html(response);
        $("#contactForm")[0].reset();
      },
      error: function () {
        $("#responseMessage").html(
          "Hubo un error al enviar el correo. Intenta nuevamente."
        );
      },
    });
  });
});
