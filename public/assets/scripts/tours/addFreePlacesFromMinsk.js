document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("mouseover", function () {
        document.getElementById("bus-to").addEventListener("focusout", function () {
            addFreePlacesFromMinsk();
        });

        document.getElementById("departure-from-minsk").addEventListener("click", function () {
            addFreePlacesFromMinsk();
        });
    });
});

async function addFreePlacesFromMinsk() {
    let url = "/tours/count";
    let bus_id = document.getElementById("bus-to").value;
    let from_minsk_date = document.getElementById("departure-from-minsk").value;

    if (bus_id < 1) {
        document.getElementById("places-to").innerHTML = '-';
        return;
    }

    let info = {
        bus_id: bus_id,
        from_minsk_date: from_minsk_date
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

    let tours_count_to = await response.json();

    let bus_url = "/busesOne/" + bus_id;
    let bus_response = await fetch(bus_url);

    if (!bus_response.ok) {
        alert("Не получилось найти автобус");
        return;
    }

    let bus = await bus_response.json();
    console.log(bus);

    let total_places_to = bus.places;

    let free_places_to = total_places_to - tours_count_to;

    document.getElementById("places-to").innerHTML = free_places_to;
}