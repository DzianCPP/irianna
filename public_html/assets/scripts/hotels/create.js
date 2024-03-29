document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", create);
})


async function create() {
    let _name = document.getElementById("name").value;
    let _resort_id = document.getElementById("resort-id").value;
    let _address = document.getElementById("address").value;
    let _rooms = document.getElementById("rooms").value;
    let _area = document.getElementById("area").value;
    let _beach = document.getElementById("beach").value;
    let _checkins = 1;
    let _housing = document.getElementById("housing").value;
    let _water = document.getElementById("water").value;
    let _food = document.getElementById("food").value;
    let _features = document.getElementById("features").value;
    let _description = document.getElementById("description").value;
    let _is_active = document.getElementById("is-active").value;

    url = "/hotels/create";

    if (_checkins === "") {
        _checkins = 1;
    }

    let info = {
        name: _name,
        resort_id: _resort_id,
        address: _address,
        area: _area,
        housing: _housing,
        beach: _beach,
        checkins: _checkins,
        rooms: _rooms,
        water: _water,
        food: _food,
        features: _features,
        description: _description,
        is_active: _is_active
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (response.ok !== false) {
        window.location = "/hotels";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Неправильно заполненная информация";
    }
}