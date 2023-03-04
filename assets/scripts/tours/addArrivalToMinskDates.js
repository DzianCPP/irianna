document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus-from").addEventListener("focusout", function () {
        addArrivalToMinsk();
    });
});

async function addArrivalToMinsk() {
    let url = "/busesOne/" + document.getElementById('bus-from').value;
    if (document.getElementById("bus-from").value == 0) {
        return;
    }
    let GET = {
        method: 'GET'
    };
    let bus = await fetch(url, GET);
    if (!bus.ok) {
        alert("Ошибка сервера");
    } else {
        let bus_info = await bus.json();
        console.log(bus_info);
        let arrival_to_minsk = bus_info.arrival_to_minsk;
        console.log(arrival_to_minsk);
        addArrivalToMinskOptions(arrival_to_minsk);
    }
}

function addArrivalToMinskOptions(arrival_to_minsk) {
    let arrival_to_minsk_selector = document.getElementById("arrival-to-minsk");
    let dates = arrival_to_minsk.trim().split("\n");
    dates = dates.sort(function(a, b){
        var aa = a.split('.').reverse().join(),
            bb = b.split('.').reverse().join();
        return aa < bb ? -1 : (aa > bb ? 1 : 0);
    });

    console.log(dates);

    for (let i = arrival_to_minsk_selector.length - 1; i >= 0; i--) {
        arrival_to_minsk_selector.remove(i);
    }

    for (var date of dates) {
        var newOption = document.createElement('option');
        var optionText = document.createTextNode(date);
        newOption.appendChild(optionText);
        newOption.setAttribute('value', date);
        arrival_to_minsk_selector.appendChild(newOption);
    }
}