document.getElementById("save-btn").addEventListener("click", createCountry);

async function createCountry() {
    let _name = document.getElementById("name").value;
    let isActive = document.getElementById("is-active").value;

    url = "/countries/create";

    let data = {
        name: _name,
        is_active: isActive
    };

    let postRequest = {
        method: "POST",
        body: JSON.stringify(data)
    };

    let response = await fetch(url, postRequest);

    if (response.ok !== false) {
        window.location="/countries/";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Неправильно заполненная информация";
    }
}