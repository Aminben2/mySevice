const form = document.forms[0];

const nom = document.querySelector("#nom");

const nameErr = document.querySelector(".name");

form.addEventListener("submit", function (e) {

    let check = 0;
    let regex = /^[a-zA-Z]+$/;
    if (!regex.test(nom.value)) {
        nomErr = "Name is inavlid must be only caracteres";
        nameErr.innerHTML = nomErr;
        check++
    }

    if (nom.value.length < 3) {
        nomErr = "Name is inavlid";
        nameErr.innerHTML = nomErr;
        check++
    }

    if (check > 0) {
        e.preventDefault()
    }
})