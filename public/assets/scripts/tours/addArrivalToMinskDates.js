document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus-from").addEventListener("change", function () {
        addArrivalToMinskDates();
    });
});

async function addArrivalToMinskDates() {
    let url = "/roomsOne/" + document.getElementById("rooms").value;
    let GET = {
        method: "GET"
    };
    let room = await fetch(url, GET);
    if (!room.ok) {
        alert("Ошибка сервера");
    } else {
        let room_info = await room.json();
        let from_resort = room_info.checkin_checkout_dates;
        console.log(from_resort);
        addOptions(from_resort);
    }
}

function addOptions(from_resort) {
    let toMinskSelector = document.getElementById("departure-from-resort");
    let dates = from_resort.trim().split(", ");

    for (let i = 0; i < dates.length; i++) {
        dates[i] = dates[i].substring(1);
    }

    console.log(dates);

    for (let i = toMinskSelector.length - 1; i >= 0; i--) {
        toMinskSelector.remove(i);
    }

    for (var date of dates) {
        var newOption = document.createElement('option');
        var optionText = document.createTextNode(date);
        newOption.appendChild(optionText);
        newOption.setAttribute('value', date);
        toMinskSelector.appendChild(newOption);
    }
}