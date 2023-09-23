const form = document.forms[0];

const nom = document.querySelector("#nom");
const description = document.querySelector("#description");
const pic = document.querySelector("#picture");

const nameErr = document.querySelector(".name");
const descErr = document.querySelector(".desc");


form.addEventListener("submit", function (e) {

    let check = 0;

    let nomErr = "";
    let descriptionErr = "";
    if (nom.value.length < 5) {
        nomErr = "Give a valid name";
        nameErr.innerHTML = nomErr;
        check++;
    }

    if (description.value.length < 5) {
        descriptionErr = "Give a valid Description";
        descErr.innerHTML = descriptionErr;
        check++;
    }

    let regex = /^[a-zA-Z]+$/;

    if (!regex.test(nom.value)) {
        nomErr = "Name is inavlid must be only caracteres";
        nameErr.innerHTML = nomErr;
        check++
    }

    if (!regex.test(description.value)) {
        descriptionErr = "Description must be only caracteres";
        descErr.innerHTML = descriptionErr;
        check++;
    }

    if (check > 0) {
        e.preventDefault();
    }


})
