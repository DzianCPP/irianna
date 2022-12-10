document.addEventListener("mouseover", formFilled);
let loginField = document.getElementById("login");
loginField.addEventListener("keyup", formFilled);
let passwordField = document.getElementById("password");
passwordField.addEventListener("keyup", formFilled);

function formFilled() {
    let loginField = document.getElementById("login");
    let passwordField = document.getElementById("password");
    let loginBtn = document.getElementById("login-btn");

    if (loginField.value.length < 1 || passwordField.value.length < 1) {
        loginBtn.disabled = true;
    } else {
        loginBtn.disabled = false;
    }
}