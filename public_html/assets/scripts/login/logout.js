document.getElementById("logout-btn").addEventListener("click", logout);

async function logout() {
    let url = "/login/logout";

    let POST = {
        method: "POST"
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        window.location = "/";
    } else {
        alert('Не удалооь выйти');
    }
}