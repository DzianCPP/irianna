document.getElementById("choose-btn").addEventListener("click", pick);

function pick() {
    let _hotel_id = document.getElementById("hotel-id").value;

    let url = "/rooms/new/" + _hotel_id;

    window.location = url;
}