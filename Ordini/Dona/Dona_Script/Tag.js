//SEZIONE DI GESTIONE TAG:
const tagInput = document.querySelector(".tag-input");
const tagArea = document.querySelector(".tag-area");
const ul = document.querySelector(".tag-area ul");


function addEvent(element) {
    //rendere l'intera area disponibile
    tagArea.addEventListener("click", () => {
        element.focus();
    });


    //popolazione array tags quando lascio il focus dall'ogg
    element.addEventListener("blur", (e) => {

        if (!element.value.match(/^\s+$/gi) && element.value !== "") {
            tags.push(e.target.value.trim());
            element.value = "";
            renderTags();
        }
    });

    // Il keycode 13 è l'invio
    //alla pressione di un tasto space o enter push della stringa scritta in tags
    element.addEventListener("keydown", (e) => {
        console.log(e);
        const value = e.target.value;
        if (
            (e.keyCode === 13) && !value.match(/^\s+$/gi) && value !== ""
        ) {
            tags.push(e.target.value.trim());
            element.value = "";
            renderTags();
        }
        //backspace cancella l'ultimo tag inserito
        if (e.keyCode === 8 && value === "") {
            tags.pop();
            renderTags();
        }
    });
}
addEvent(tagInput);


// separo i tag e genero delle nuove variabili usate per inserire 
// mettendoci il focus per inserire altri tag
function renderTags() {
    ul.innerHTML = "";
    tags.forEach((tag, index) => {
        createTag(tag, index);
    });
    const input = document.createElement("input");
    input.type = "text";
    input.className = "tag-input";
    addEvent(input);
    ul.appendChild(input);
    input.focus();

}


function createTag(tag, index) {
    const li = document.createElement("li");
    li.className = "tag";
    const text = document.createTextNode(tag);
    const span = document.createElement("span");
    span.className = "cross";
    span.dataset.index = index;
    //elimino l'elemento sulla quale clicco la cross tramite l'index associato
    span.addEventListener("click", (e) => {
        tags = tags.filter((_, index) => index != e.target.dataset.index);
        renderTags();
    });

    li.appendChild(text);
    li.appendChild(span);
    ul.appendChild(li);

}


//Gestione Scelta Utente sui Tag:
function setTag(check) {
    if (check == 1) {
        $("#bottoni2").hide();
        $("#Tag").show();
    }
    else {
        $("#bottoni2").fadeOut();
        $("#Tag").hide();
    }
}

//Al focusout di "nome prodotto" far comparire la scelta d'inserimento dei Tag:
$("#nomeP").blur(function () {
    if (flagTag == 0) { 
        //La scelta è unica per prodotto, è inutile che ad ogni FocusOut l'utente debba dire "Sì o No" all'immissione di tag per quel prodotto.
        if (($(this).val()) != "") {
            flagTag = 1;
            $("#bottoni2").show();
        }
        else $("#bottoni2").hide();
    }
});