document.getElementById("email").addEventListener("keyup", formFilled);
document.getElementById("password").addEventListener("keyup", formFilled);
document.getElementById("login").addEventListener("keyup", formFilled);
document.getElementById("super-admin").addEventListener("change", formFilled);
document.body.addEventListener("mouseover", formFilled);


function formFilled() {
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let login = document.getElementById("login");

    let inputs = new Array(email, password, login);
    let registerBtn = document.getElementById("submit-button");
    registerBtn.disabled = true;

    for (let input of inputs) {
        if (input.value.length > 3) {
            registerBtn.disabled = false;
        } else {
            registerBtn.disabled = true;
            break;
        }
    }
    
}