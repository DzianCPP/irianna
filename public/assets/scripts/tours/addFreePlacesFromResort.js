document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("load", function () {
        document.getElementById("bus-from").addEventListener("focusout", function () {
            addFreePlacesFromResort();
        });

        document.getElementById("arrival-to-minsk").addEventListener("click", function () {
            addFreePlacesFromResort();
        });
    });
});

async function addFreePlacesFromResort() {
    let url = "/tours/countPlacesBack";
    let bus_id = document.getElementById("bus-from").value;
    let from_resort_date = document.getElementById("room-checkout-date").value;
    let arrival_to_minsk = document.getElementById("arrival-to-minsk").value;

    if (bus_id < 1) {
        document.getElementById("places-from").innerHTML = '-';
        return;
    }

    let info = {
        bus_id: bus_id,
        arrival_to_minsk: arrival_to_minsk
    };

    let POST = {
        method: 'POST',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (!response.ok) {
        alert("Не получилось узнать кол-во свободных мест");
        return;
    }

    let tours_count = await response.json();

    let bus_url = "/busesOne/" + bus_id;
    let bus_response = await fetch(bus_url);

    if (!bus_response.ok) {
        alert("Не получилось найти автобус");
        return;
    }

    let bus = await bus_response.json();
    console.log(bus);

    let total_places = bus.places;

    let free_places = total_places - tours_count;

    document.getElementById("places-from").innerHTML = free_places;
}