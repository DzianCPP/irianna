document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotels").addEventListener("click", function () {
        addDates();
    });
});

function addDates() {
    let free_dates = JSON.parse(document.getElementById("free-dates").innerHTML);

    let checkin_dates = free_dates['in_dates'];
    let checkout_dates = free_dates['out_dates'];

    let unique = [];

    for (let in_date of checkin_dates) {
        if (!unique.includes(in_date)) {
            unique.push(in_date);
        }
    }

    checkin_dates = unique.sort();

    unique = [];

    for (let out_date of checkout_dates) {
        if (!unique.includes(out_date)) {
            unique.push(out_date);
        }
    }

    checkout_dates = unique.sort();

    unique = [];

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