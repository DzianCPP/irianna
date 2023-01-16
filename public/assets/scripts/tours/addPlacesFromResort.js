document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("departure-from-resort").addEventListener("change", function () {
        addPlacesFromResort();
    });
});

async function addPlacesFromResort() {
    let _bus_id = document.getElementById("bus-from").value;
    let _date = document.getElementById("departure-from-resort").value;
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
        document.getElementById("places-from").innerHTML = places;
    }
}