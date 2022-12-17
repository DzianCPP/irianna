document.getElementById("save-btn").addEventListener("click", edit);

async function edit() {
    let _name = document.getElementById("name").value;
    let _is_active = document.getElementById("is-active").value;
    let _id = document.getElementById("id").value;

    let url = "/countries/update";

    let newInfo = {
        name: _name,
        is_active: _is_active,
        id: _id
    };

    let putRequest = {
        method: "PUT",
        body: JSON.stringify(newInfo)
    };

    let response = await fetch(url, putRequest);

    if (response.ok !== false) {
        window.location = "/countries/";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Неверное имя страны";
    }
}