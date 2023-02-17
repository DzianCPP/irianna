document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus-to").addEventListener("change", function () {
        addDepartureFromMinskDates();
    });
});

async function addDepartureFromMinskDates() {
    if (document.getElementById("bus-to").value == 0) {
        return;
    }
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
        addOptionsFromMinsk(from_minsk);
    }
}

function addOptionsFromMinsk(from_minsk) {
    let fromMinskSelector = document.getElementById("departure-from-minsk");
    let dates = from_minsk.trim().split("\n");
    dates = dates.sort(function(a, b){
        var aa = a.split('.').reverse().join(),
            bb = b.split('.').reverse().join();
        return aa < bb ? -1 : (aa > bb ? 1 : 0);
    });

    console.log(dates);

    for (let i = fromMinskSelector.length - 1; i >= 0; --i) {
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