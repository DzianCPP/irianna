let email = document.getElementById("email");
email.addEventListener("keyup", formFilled);
let repeatEmail = document.getElementById("repeat-email");
repeatEmail.addEventListener("keyup", formFilled);
let password = document.getElementById("password");
password.addEventListener("keyup", formFilled);
let repeatPassword = document.getElementById("repeat-password");
repeatPassword.addEventListener("keyup", formFilled);
let login = document.getElementById("login");
login.addEventListener("keyup", formFilled);

function formFilled() {
    let email = document.getElementById("email");
    let repeatEmail = document.getElementById("repeat-email");
    let password = document.getElementById("password");
    let repeatPassword = document.getElementById("repeat-password");
    let login = document.getElementById("login");

    let inputs = new Array(email, repeatEmail, password, repeatPassword, login);
    let registerBtn = document.getElementById("register-btn");
    registerBtn.disabled = true;

    for (let input of inputs) {
        if (input.value.length > 0) {
            registerBtn.disabled = false;
        } else {
            registerBtn.disabled = true;
            break;
        }
    }
    
}