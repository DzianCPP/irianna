document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("departure-from-minsk").addEventListener("change", function () {
        addPlacesFromMinsk();
    });
});

async function addPlacesFromMinsk() {
    let _bus_id = document.getElementById("bus-to").value;
    let _date = document.getElementById("departure-from-minsk").value;
    let url = "/tours/places";
    let info = {
        bus_id: _bus_id,
        date: _date
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (!response.ok) {
        alert(0);
    } else {
        let places = await response.json();
        document.getElementById("places-to").innerHTML = places;
    }
}