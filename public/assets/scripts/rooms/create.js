document.addEventListener("DOMContentLoaded", function () {
    let saves = document.getElementsByName("save");

    for (let save of saves) {
        let saveBtn = save;
        saveBtn.addEventListener("click", function () {
            createRoom(saveBtn.id);
        });
    }
});

async function createRoom(btnId) {
    let roomId = btnId.substr(5);
    let checkins = document.getElementsByName("checkin-date-room-" + roomId);
    let checkouts = document.getElementsByName("checkout-date-room-" + roomId);
    let checkin_dates = new Array();
    let checkout_dates = new Array();

    for (let checkin of checkins) {
        checkin_dates.push(checkin.value);
    }

    for (let checkout of checkouts) {
        checkout_dates.push(checkout.value);
    }

    let checkin_obj = {};

    for (var i = 0; i < checkin_dates.length; i++) {
        var key = "checkin_date_" + (i + 1);
        Object.defineProperty(checkin_obj, key, {
            value: checkin_dates[i],
            enumerable: true
        });
    }

    let checkout_obj = {};

    for (var i = 0; i < checkout_dates.length; i++) {
        var key = "checkout_date_" + (i + 1);
        Object.defineProperty(checkout_obj, key, {
            value: checkout_dates[i],
            enumerable: true
        });
    }

    let _checkin_checkout_dates = JSON.stringify(Object.assign(checkin_obj, checkout_obj));

    let hotel_ids = document.getElementsByName("hotel-id");

    let _hotel_id = hotel_ids[roomId].value;

    let descriptions = document.getElementsByName("room-description");

    let _description = descriptions[roomId].value;

    let info = {
        checkin_checkout_dates: _checkin_checkout_dates,
        hotel_id: _hotel_id,
        description: _description
    };

    let url = "/rooms/create";

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    }

    let response = await fetch(url, POST);

    if (response.ok != false) {
        location.reload();
    } else {
        alert("error");
    }
}