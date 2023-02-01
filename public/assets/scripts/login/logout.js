document.getElementById("logout-btn").addEventListener("click", logout);

async function logout() {
    let url = "/login/logout";

    let getRequest = {
        method: "POST"
    };

    let response = await fetch(url, getRequest);

    if (response.ok != false) {
        window.location = "/";
    }
}