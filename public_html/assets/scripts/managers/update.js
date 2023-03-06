document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", update);
});

async function update() {
    let _name = document.getElementById("name").value;
    let _id = document.getElementById("id").innerHTML;
    let url = "/managers/update";

    let info = {
        name: _name,
        id: _id
    };

    let PUT = {
        method: "PUT",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, PUT);

    if (response.ok != false) {
        window.location = "/managers";
    } else {
        document.getElementById("error-field").innerHTML = "Неверно заполненные данные";
        return;
    }
}