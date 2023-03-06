document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        set();
    });
});

async function set() {
    let url = "/currencies/create";
    let currencies_list = document.getElementById("currencies").value.split(', ');

    let info = {
        currencies: currencies_list
    };

    let POST = {
        method: 'POST',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);
    if (!response.ok) {
        alert("Ошибка!");
    } else {
        window.location = "/tours/new";
    }
}