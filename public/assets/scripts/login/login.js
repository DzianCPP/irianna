let loginBtn = document.getElementById("login-btn");
loginBtn.addEventListener("click", login);

async function login() {
    let _login = document.getElementById("login").value;
    let _password = document.getElementById("password").value;
    let url = "/login/login";
    let data = {
        login: _login,
        password: _password
    };

    let postRequest = {
        method: "POST",
        body: JSON.stringify(data)
    };

    let response = await fetch(url, postRequest);

    if (response.status === 205) {
        window.location = "/admin/";
    }

    if (response.status === 401) {
        document.getElementById("login").style.color = "red";
    }

}