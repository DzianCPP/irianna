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
}

function getCheckinCheckoutDates() {
    let checkins = getCheckins();
    let checkouts = getCheckouts();

    let dates = checkins + checkouts;

    return dates;
}

function getCheckins() {
    return document.getElementsByName("checkins")[0].value;
}

function getCheckouts() {
    return document.getElementsByName("checkouts")[0].value;
}