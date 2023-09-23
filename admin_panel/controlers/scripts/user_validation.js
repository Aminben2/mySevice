const form = document.forms[0];

const prenom = document.querySelector("#prenom")
const nom = document.querySelector("#nom")
const role = document.querySelector("#role")
const email = document.querySelector("#email")


const prenom_error = document.querySelector("#prenomErr")
const nom_error = document.querySelector("#nomErr")
const role_error = document.querySelector("#roleErr")
const email_error = document.querySelector("#emailErr")



form.addEventListener("submit", function (e) {
    // Regular expressions for validation
    const nameRegex = /^[A-Za-z]+$/;
    const emailRegex = /^([a-zA-Z\d\.-]+)@([a-zA-Z\d-]{2,8})\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
    const roles = ["user", "admin", "pro"]

    let check = 0;

    if (!nameRegex.test(prenom.value)) {
        let fNmaeErr = "Invalid first name.";
        prenom_error.innerHTML = fNmaeErr
        check++
    }

    if (!nameRegex.test(nom.value)) {
        let lNmaeErr = "Invalid last name.";
        nom_error.innerHTML = lNmaeErr
        check++
    }

    if (!emailRegex.test(email.value)) {
        let emailErr = "Invalid email address.";
        email_error.innerHTML = emailErr
        check++
    }
    if (!roles.includes(role.value)) {
        let roleErr = "Invalid role";
        role_error.innerHTML = roleErr
        check++
    }

    if (check > 0) {
        e.preventDefault()
    }
})



