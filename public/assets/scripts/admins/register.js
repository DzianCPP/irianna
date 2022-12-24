document.getElementById("register-btn")
    .addEventListener("click", sendPostRequest);

async function sendPostRequest() {
    let setEmail = document.getElementById("email").value;
    let setLogin = document.getElementById("login").value;
    let setPassword = document.getElementById("password").value;

    let url = "/admins/create";

    let newAdmin = {
        email: setEmail,
        login: setLogin,
        password: setPassword
    };

    let postRequest = {
        method: "POST",
        body: JSON.stringify(newAdmin)
    };

    let response = await fetch(url, postRequest);

    if (response.ok !== false) {
        window.location="/admin/";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Wrong name or email";
        let emailField = document.getElementById("email");
        emailField.style.color = "red";
        let loginField = document.getElementById("login");
        loginField.style.color = "red";
    }
}