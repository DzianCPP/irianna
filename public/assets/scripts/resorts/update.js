document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("save_btn").addEventListener("click", update);
})

async function update() {
    let _name = document.getElementById("name").value;
    let _country_id = document.getElementById("country").value;
    let _is_active = document.getElementById("is-active").value;
    let _id = document.getElementById("id").innerHTML;

    let url = "/resorts/update";

    let data = {
        name: _name,
        is_active: _is_active,
        country_id: _country_id,
        id: _id
    };

    let putRequest = {
        method: "PUT",
        body: JSON.stringify(data)
    };

    let response = await fetch(url, putRequest);

    if (response.ok != false) {
        window.location = "/resorts";
    } else {
        document.getElementById("error-field").innerHTML = "Ошибка! Одно из полей заполнено неверно";
    }
}