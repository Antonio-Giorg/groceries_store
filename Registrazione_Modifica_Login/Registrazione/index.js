togglePassword.addEventListener("click", function () {
    // Rendo il testo chiaro o lo nascondo
    const type = pass.getAttribute("type");
    if (type == "password") {
        $("#pass").attr('type', 'text');
    }
    else {
        $("#pass").attr('type', 'password');
    }

    // Cambio l'icona
    this.classList.toggle("bi-eye");
});

$("#pass").focus(function () {
    $("#req").fadeIn();
});

$("#pass").focusout(function () {
    $("#req").fadeOut();
});