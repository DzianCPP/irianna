document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bus").addEventListener("change", function () {
        addFromMinskDates();
    });
});

async function addFromMinskDates() {
    let bus_id = document.getElementById("bus").value;

    for (let i = document.getElementById("from-minsk-date").length; i >= 0; --i) {
        document.getElementById("from-minsk-date").remove(i);
    }

    for (let i = document.getElementById("to-minsk-date").length; i >= 0; --i) {
        document.getElementById("to-minsk-date").remove(i);
    }
    if (bus_id == 0) {
        return;
    }
    let bus = {};
    let bus_info = await getBusDates(bus_id);

    if (bus_info == "Ошибка") {
        return;
    } else {
        bus = bus_info;
    }

    let from_minsk_dates = bus.departure_from_minsk.split("\n");

    let empty_option = document.createElement("option");
    let empty_option_text = document.createTextNode("");
    empty_option.appendChild(empty_option_text);
    empty_option.setAttribute("value", "empty");
    empty_option.setAttribute("class", "bg-light text-success");

    document.getElementById("from-minsk-date").appendChild(empty_option);

    for (let date of from_minsk_dates) {
        let new_option = document.createElement("option");
        let option_text = document.createTextNode(date);
        new_option.appendChild(option_text);
        new_option.setAttribute("value", date);
        new_option.setAttribute("class", "bg-light text-success");
        document.getElementById("from-minsk-date").appendChild(new_option);
    }

    let to_minsk_dates = bus.arrival_to_minsk.split("\n");

    let to_minsk_empty_option = document.createElement("option");
    let to_minsk_empty_option_text = document.createTextNode("");
    to_minsk_empty_option.appendChild(to_minsk_empty_option_text);
    to_minsk_empty_option.setAttribute("value", "empty");
    to_minsk_empty_option.setAttribute("class", "bg-light text-success");
    document.getElementById("to-minsk-date").appendChild(to_minsk_empty_option);

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