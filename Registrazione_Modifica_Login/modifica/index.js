var regione = $("#boxRegione").val();
$("#boxRegione").focus(function () {
    $(this).val("");
});
$("#boxRegione").focusout(function () {
    if ($(this).val() == "") {
        $(this).val(regione);
    }
    else {
        regione = ($("#boxRegione").val());
    }
});

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