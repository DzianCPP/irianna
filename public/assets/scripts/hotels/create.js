document.getElementById("save-btn-1").addEventListener("click", () => { create(1); });
document.getElementById("save-btn-1").addEventListener("click", () => { create(2); });
document.getElementById("save-btn-1").addEventListener("click", () => { create(3); });



async function create(__id) {
    let _name = document.getElementById("name-" + __id).value;
    let _resort_id = document.getElementById("resort-id-" + __id).value;
    let _address = document.getElementById("address-" + __id).value;
    let _area = document.getElementById("area-" + __id).value;
    let _beach = document.getElementById("beach-" + __id).value;
    let _number = document.getElementById("number-" + __id).value;
    let _water = document.getElementById("water-" + __id).value;
    let _food = document.getElementById("food-" + __id).value;
    let _features = document.getElementById("features-" + __id).value;
    let _description = document.getElementById("description-" + __id).value;
    let _is_active = document.getElementById("is-active-" + __id).value;

    url = "/hotels/create";

    let info = {
        name: _name,
        resort_id: _resort_id,
        address: _address,
        area: _area,
        beach: _beach,
        number: _number,
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