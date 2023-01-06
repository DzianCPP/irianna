document.addEventListener("DOMContentLoaded", function () {
    let saves = document.getElementsByName("save");

    for (let save of saves) {
        save.addEventListener("click", function () {
            saveRooms();
        });
    }
});

async function saveRooms() {
    let _rooms = getRoomsInfo();
    let newRooms = new Object(_rooms);

    let url = "/rooms/create";

    let POST = {
        method: "POST",
        body: stringifyToJson(newRooms)
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        window.location = "/admin";
    } else {
        alert("Что-то пошло не так!");
    }
}

function getRoomsInfo() {
    let rooms = {};

    for (var i = 0; i < getCountOfRooms(); i++) {
        Object.defineProperty(rooms, i, {
            value: getRoom(i),
            enumerable: true
        })
    }

    return rooms;
}

function getRoom(i) {
    return {
        hotel_id: getHotelId()[i],
        description: getDescriptions()[i].value,
        checkin_checkout_dates: getCheckinCheckoutDates()["room-" + i],
        comforts: getGetComforts()[i].value,
        food: getFood()[i].value
    };
}

function getDescriptions() {
    return document.getElementsByName("room-description");
}

function getHotelId() {
    return document.getElementById("hotel-id").innerHTML;
}

function getCountOfRooms() {
    return document.getElementsByTagName("th").length - 1;
}

function getGetComforts() {
    return document.getElementsByName("comfort");
}

function getFood() {
    return document.getElementsByName("food");
}

function getCheckinCheckoutDates() {
    let checkins = getCheckins();
    let checkouts = getCheckouts();

    let dates = {};

    for (var i = 0; i < getCountOfRooms(); i++) {
        var json = checkins[i].value + checkouts[i].value;
        Object.defineProperty(dates, "room-" + i, {
            value: json
        });
    }

    return dates;
}

function getCheckins() {
    return document.getElementsByName("checkins");
}

function getCheckouts() {
    return document.getElementsByName("checkouts");
}

function stringifyToJson(value) {
    return JSON.stringify(value);
}