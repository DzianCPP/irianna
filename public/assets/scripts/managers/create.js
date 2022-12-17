document.getElementById("save-btn").addEventListener("click", create);

async function create() {
    let url = "/managers/create";
    let _name =
        document.getElementById("last-name").value + " " +
        document.getElementById("first-name").value + " " +
        document.getElementById("second-name").value;

    let info = {
        name: _name
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (response.ok !== false) {
        window.location = "/managers";
    } else {
        document.getElementById("error-field").innerHTML = "Неверные данные";
    }
}