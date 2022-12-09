let logoutBtn = document.getElementById("logout-btn");
logoutBtn.addEventListener("click", logout);

async function logout() {
    document.cookie = "logged=0";
    let url = "/admin/";

    let getRequest = {
        method: "GET"
    };

    let response = await fetch(url, getRequest);

    if (response.status === 200) {
        window.location = "/admin/";
    }
}