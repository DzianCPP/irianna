document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("rooms").addEventListener("click", function () {
        addCheckinDates();
    });
});

async function addCheckinDates() {
    let free_dates = await getCheckinDates(document.getElementById("rooms").value);

    let checkin_dates = free_dates['checkin_dates'];
    let checkout_dates = free_dates['checkout_dates'];

    for (let date of checkin_dates) {
        let option = document.createElement('option');
        let text = document.createTextNode(date);
        option.appendChild(text);
        option.setAttribute('value', text);
        document.getElementById("room-checkin-date").appendChild(option);
    }

    for (let date of checkout_dates) {
        let option = document.createElement('option');
        let text = document.createTextNode(date);
        option.appendChild(text);
        option.setAttribute('value', text);
        document.getElementById("room-checkout-date").appendChild(option);
    }
}

async function getCheckinDates(room_id) {
    let url = "/rooms/free/" + room_id;

    let response = await fetch(url);
    if (!response.ok) {
        console.log("Не удалось получить свободные даты");
        alert("Ошибка! Не удалось получить свободные даты");
        return;
    }

    return await response.json();
}