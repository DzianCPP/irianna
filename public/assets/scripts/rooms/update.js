document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        update();
    });
});

async function update() {
    let url = "/rooms/update/";
    let _description = document.getElementsByName("room-description")[0].value;
    let _comfort = document.getElementsByName("comfort")[0].value;
    let _food = document.getElementsByName("food")[0].value;
    let _checkin_checkout_dates = getCheckinCheckoutDates();
    let _room_id = document.getElementById("room-id").innerHTML;
    let _room_hotel_id = document.getElementById("room-hotel-id").innerHTML;

    let info = {
        id: _room_id,
        hotel_id: _room_hotel_id,
        description: _description,
        checkin_checkout_dates: _checkin_checkout_dates,
        comforts: _comfort,
        food: _food
    };

    let PUT = {
        method: 'PUT',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, PUT);

    if (response.ok != false) {
        window.location = "/rooms/" + _room_hotel_id;
    } else {
        alert("Что-то пошло не так!");
    }
}

function getCheckinCheckoutDates() {
    let checkins = getCheckins();
    let checkouts = getCheckouts();
    let dates = checkins + checkouts;

    return dates;
}

function getCheckins() {
    return document.getElementsByName("checkins")[0].value.trim()+"\n";
}

function getCheckouts() {
    return document.getElementsByName("checkouts")[0].value.trim()+"\n";
}