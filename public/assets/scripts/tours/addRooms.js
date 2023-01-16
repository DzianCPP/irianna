document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotels").addEventListener("click", addRooms);
})

function addRooms() {
    let hotel = document.getElementById("hotels").value;
    let roomsSelector = document.getElementById("rooms");
    let rooms = JSON.parse(document.getElementById("rooms-array").innerHTML);

    for (let i = 0; i < roomsSelector.length; i++) {
        roomsSelector.removeChild(roomsSelector.options[i]);
    }

    for (var room of rooms) {
        if (room.hotel_id == hotel) {
            var newOption = document.createElement('option');
            var optionText = document.createTextNode(room.description);
            newOption.appendChild(optionText);
            newOption.setAttribute('value', room.id);
            roomsSelector.appendChild(newOption);
        }
    }
}