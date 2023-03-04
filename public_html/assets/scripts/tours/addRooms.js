document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("room-checkin-date").addEventListener("click", addRooms);
    document.getElementById("room-checkout-date").addEventListener("click", addRooms);
})

function addRooms() {
    let hotel = document.getElementById("hotels").value;
    let checkin_date = document.getElementById("room-checkin-date").value;
    let checkout_date = document.getElementById("room-checkout-date").value;
    let roomsSelector = document.getElementById("rooms");
    let rooms = JSON.parse(document.getElementById("rooms-array").innerHTML);

    for (let i = roomsSelector.length; i >= 0; --i) {
        roomsSelector.remove(i);
    }

    let i = 0;

    for (var room of rooms) {
        if (room.hotel_id == hotel) {
            if (room['checkin_dates'].includes(checkin_date, 0) && room['checkout_dates'].includes(checkout_date, 0)) {
                var newOption = document.createElement('option');
                var optionText = document.createTextNode(++i + ": " + room.description);
                newOption.appendChild(optionText);
                newOption.setAttribute('value', room.id);
                roomsSelector.appendChild(newOption);
            }
        }
    }
}