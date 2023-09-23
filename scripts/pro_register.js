const form = document.forms[0];

const etab_name = document.querySelector("#etab_name")
const etab_address = document.querySelector("#etab_address")
const license = document.querySelector("#license")


const etabName_error = document.querySelector("#etab_nameErr")
const etabaddress_error = document.querySelector("#etab_addressErr")
const license_error = document.querySelector("#licenseErr")



form.addEventListener("submit", function (e) {
    // Regular expressions for validation
    const nameRegex = /^[A-Za-z]+$/;
    const alphanumericRegex = /^[a-zA-Z0-9]+$/;

    let check = 0;

    if (!nameRegex.test(etab_name.value)) {
        let nameErr = "Invalid name only caratcters.";
        etab_name.innerHTML = nameErr
        check++
    }

    if (!alphanumericRegex.test(license.value)) {
        let licenseErr = "Invalid license";
        license_error.innerHTML = licenseErr
        check++
    }

    if (etab_address.value.trim() === "") {
        let addressErr = "Address is required.";
        etabaddress_error.innerHTML = addressErr
        check++
    }


    if (check > 0) {
        e.preventDefault()
    }
})



