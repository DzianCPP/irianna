document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotel").addEventListener("change", function () {
        addDates();
    });
});

async function addDates() {
    let url = "/rooms/dates/" + document.getElementById("hotel").value;
    let response = await fetch(url);

    if (!response.ok) {
        alert("Ошибка! Не удалось получить даты номеров");
        return;
    }

    let json_dates = await response.json();

    for (let i = document.getElementById("checkin-date").length; i >= 0; i--) {
        document.getElementById("checkin-date").remove(i);
    }

    for (let i = document.getElementById("checkout-date").length; i >= 0; i--) {
        document.getElementById("checkout-date").remove(i);
    }

    let dates = json_dates;

    let checkin_dates = dates.checkin_dates;
    let checkout_dates = dates.checkout_dates;

    for (let _in of checkin_dates) {
        let new_option = document.createElement('option');
        new_option.setAttribute('value', _in);
        new_option.innerHTML = _in;
        document.getElementById("checkin-date").appendChild(new_option);
    }

    for (let _out of checkout_dates) {
        let new_option = document.createElement('option');
        new_option.setAttribute('value', _out);
        new_option.innerHTML = _out;
        document.getElementById("checkout-date").appendChild(new_option);
    }
}