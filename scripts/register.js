const form = document.forms[0];

const f_name = document.querySelector("#f_name")
const l_name = document.querySelector("#l_name")
const username = document.querySelector("#username")
const email = document.querySelector("#email")
const adress = document.querySelector("#adress")
const password = document.querySelector("#password")
const confirm = document.querySelector("#confirm")

const fName_error = document.querySelector("#fNameErr")
const lName_error = document.querySelector("#lNameErr")
const username_error = document.querySelector("#usernameErr")
const email_error = document.querySelector("#emailErr")
const address_error = document.querySelector("#addressErr")
const password_error = document.querySelector("#passwordErr")
const confirm_error = document.querySelector("#confirmErr")


form.addEventListener("submit", function (e) {
    // Regular expressions for validation
    const nameRegex = /^[A-Za-z]+$/;
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}$/;
    const alphanumericRegex = /^[a-zA-Z0-9]+$/;
    const usernameRegex = "/^[a-zA-Z0-9_]{7,29}$/";

    let check = 0;

    if (username.value.length < 3 || !usernameRegex.test(username.value)) {
        let usernameErr = "Invlid username, Try again";
        username_error.innerHTML = usernameErr
        check++
    }

    if (!nameRegex.test(f_name.value)) {
        let fNmaeErr = "Invalid first name.";
        fName_error.innerHTML = fNmaeErr
        check++
    }

    if (!nameRegex.test(l_name.value)) {
        let lNmaeErr = "Invalid last name.";
        lName_error.innerHTML = lNmaeErr
        check++
    }

    if (!emailRegex.test(email.value)) {
        let emailErr = "Invalid email address.";
        email_error.innerHTML = emailErr
        check++
    }

    if (adress.value.trim() === "") {
        let addressErr = "Address is required.";
        address_error.innerHTML = addressErr
        check++
    }

    if (!passwordRegex.test(password.value)) {
        let passwordErr = "Please choose a stronger password.";
        password_error.innerHTML = passwordErr
        check++
    }

    if (password.value !== confirm.value && passwordRegex.test(password.value)) {
        let confirmErr = "Passwords do not match";
        confirm_error.innerHTML = confirmErr
        check++
    }

    if (check > 0) {
        e.preventDefault()
    }
})



