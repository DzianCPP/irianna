document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus").addEventListener("click", function () {
        addFromMinskDates();
    });
});

async function addFromMinskDates() {
    let bus_id = document.getElementById("bus").value;
    let bus = {};
    let bus_info = await getBusDates(bus_id);

    if (bus_info == "Ошибка") {
        return;
    } else {
        bus = bus_info;
    }

    let from_minsk_dates = bus.departure_from_minsk.split("\n");

    for (let date of from_minsk_dates) {
        let new_option = document.createElement("option");
        let option_text = document.createTextNode(date);
        new_option.appendChild(option_text);
        new_option.setAttribute("value", date);
        new_option.setAttribute("class", "bg-light text-success");
        document.getElementById("from-minsk-date").appendChild(new_option);
    }

    let to_minsk_dates = bus.arrival_to_minsk.split("\n");

    for (let date of to_minsk_dates) {
        let new_option = document.createElement("option");
        let option_text = document.createTextNode(date);
        new_option.appendChild(option_text);
        new_option.setAttribute("value", date);
        new_option.setAttribute("class", "bg-light text-success");
        document.getElementById("to-minsk-date").appendChild(new_option);
    }
}

async function getBusDates(bus_id) {
    let url = "/buses/readOne/" + bus_id;
    let GET = {
        method: 'GET'
    };

    let response = await fetch(url, GET);

    if (!response.ok) {
        console.log("Ошибка! Не удалось получить данные этого автобуса");
        alert("Ошибка!");
        return "Ошибка";
    } else {
        let bus_info = await response.json();
        return bus_info;
    }
}