document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotels").addEventListener("click", function () {
        addDates();
    });
});

async function addDates() {
    let free_dates = await getDates(document.getElementById("hotels").value);

    let checkin_dates = free_dates['checkin_dates'];
    let checkout_dates = free_dates['checkout_dates'];

    for (let i = document.getElementById("room-checkin-date").length; i >= 0; i--) {
        document.getElementById("room-checkin-date").remove(i);
    }

    for (let i = document.getElementById("room-checkout-date").length; i >= 0; i--) {
        document.getElementById("room-checkout-date").remove(i);
    }

    for (let date of checkin_dates) {
        let option = document.createElement('option');
        let text = document.createTextNode(date);
        option.appendChild(text);
        option.setAttribute('value', text.textContent);
        document.getElementById("room-checkin-date").appendChild(option);
    }

    for (let date of checkout_dates) {
        let option = document.createElement('option');
        let text = document.createTextNode(date);
        option.appendChild(text);
        option.setAttribute('value', text.textContent);
        document.getElementById("room-checkout-date").appendChild(option);
    }
}

async function getDates(room_id) {
    let url = "/rooms/free/" + room_id;

    let response = await fetch(url);
    if (!response.ok) {
        console.log("Не удалось получить свободные даты");
        alert("Ошибка! Не удалось получить свободные даты");
        return;
    }

    return await response.json();
}