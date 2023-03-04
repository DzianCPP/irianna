document.getElementById("repeat-email").addEventListener("keyup", fieldsEqual);
document.getElementById("repeat-password").addEventListener("keyup", fieldsEqual);

function fieldsEqual() {
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let error = document.getElementById("error-field");

    if (email.value != repeatEmail.value) {
        error.innerHTML = "Адреса почтовых ящиков должны совпадать";
        document.getElementById("register-btn").disabled = true;
        return false;
    } else {
        error.innerHTML = "";
    }

    if (password.value != repeatPassword.value) {
        error.innerHTML = "Пароли должны совпадать";
        document.getElementById("register-btn").disabled = true;
        return false;
    } else {
        error.innerHTML = "";
    }
}