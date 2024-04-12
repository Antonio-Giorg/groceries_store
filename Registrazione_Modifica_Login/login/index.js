$(document).ready(function () {
    
    
    if (variabile == true) {
        document.getElementById("rmb").checked = true;
    }
    else {
        document.getElementById("rmb").checked = false;
    }
});

togglePassword.addEventListener("click", function () {
    // Rendo o nascondo il testo
    const type = password.getAttribute("type");
    if (type == "password") {
        $("#password").attr('type', 'text');
    }
    else {
        $("#password").attr('type', 'password');
    }

    // Cambio l'icona dell'occhio
    this.classList.toggle("bi-eye");
});


