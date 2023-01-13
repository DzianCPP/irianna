document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus-to").addEventListener("change", function () {
        addDepartureFromMinskDates();
    });
});

async function addDepartureFromMinskDates() {
    let url = "/busesOne/" + document.getElementById("bus-to").value;
    let GET = {
        method: "GET"
    };
    let bus = await fetch(url, GET);
    if (!bus.ok) {
        alert("Ошибка сервера");
    } else {
        let bus_info = await bus.json();
        let from_minsk = bus_info.departure_from_minsk;
        addOptions(from_minsk);
    }
}

function addOptions(from_minsk) {
    let fromMinskSelector = document.getElementById("departure-from-minsk");
    let dates = from_minsk.trim().split("\n");

    console.log(dates);

    for (let i = fromMinskSelector.length - 1; i >= 0; i--) {
        fromMinskSelector.remove(i);
    }

    for (var date of dates) {
        var newOption = document.createElement('option');
        var optionText = document.createTextNode(date);
        newOption.appendChild(optionText);
        newOption.setAttribute('value', date);
        fromMinskSelector.appendChild(newOption);
    }
}