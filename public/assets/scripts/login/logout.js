let logoutBtn = document.getElementById("logout-btn");
logoutBtn.addEventListener("click", logout);

async function logout() {
    let url = "/login/logout";

    let getRequest = {
        method: "POST"
    };

    let response = await fetch(url, getRequest);

    if (response.status === 205) {
        location.reload(true);
    }
}