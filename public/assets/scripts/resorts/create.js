document.getElementById("save-btn").addEventListener("click", create);

async function create() {
    let _name = document.getElementById("name").value;
    let _country_id = document.getElementById("country").value;
    let _is_active = document.getElementById("is-active").value;

    url = "/resorts/create";

    let info = {
        name: _name,
        country_id: _country_id,
        is_active: _is_active
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (response.ok !== false) {
        window.location = "/resorts";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Неправильно заполненная информация";
    }
}