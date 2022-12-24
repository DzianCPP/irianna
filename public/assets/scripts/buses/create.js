document.getElementById("save-btn-1").addEventListener("click", () => { create(1); });
document.getElementById("save-btn-1").addEventListener("click", () => { create(2); });
document.getElementById("save-btn-1").addEventListener("click", () => { create(3); });



async function create(__id) {
    let _name = document.getElementById("name-" + __id).value;
    let _route = document.getElementById("route-" + __id).value;
    let _places = document.getElementById("route-" + __id).value;
    let _fromMinsk = document.getElementById("departure-from-minsk-" + __id).value;
    let _fromResort = document.getElementById("departure-from-resort-" + __id).value;
    let _toMinsk = document.getElementById("arrival-to-minsk-" + __id).value;

    url = "/buses/create";

    let info = {
        name: _name,
        route: _route,
        places: _places,
        departure_from_minsk: _fromMinsk,
        departure_from_resort: _fromResort,
        arrival_to_minsk: _toMinsk
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (response.ok !== false) {
        window.location = "/buses";
    } else {
        let errorField = document.getElementById("error-field-" + __id);
        errorField.innerHTML = "Неправильно заполненная информация";
    }
}