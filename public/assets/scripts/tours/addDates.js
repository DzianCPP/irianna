document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotels").addEventListener("click", function () {
        addDates();
    });
});

async function addDates() {
    // let free_dates = JSON.parse(document.getElementById("free-dates").innerHTML);

    let json_dates_raw = await getFreeDates();
    
    let free_dates = json_dates_raw;
    let checkin_dates = free_dates['in_dates'];
    let checkout_dates = free_dates['out_dates'];

    let unique = [];

    for (let in_date of checkin_dates) {
        if (!unique.includes(in_date)) {
            unique.push(in_date);
        }
    }

    checkin_dates = unique.sort(function (a, b) {
        var aa = a.split('.').reverse().join(),
            bb = b.split('.').reverse().join();
        return aa < bb ? -1 : (aa > bb ? 1 : 0);
    });

    unique = [];

    for (let out_date of checkout_dates) {
        if (!unique.includes(out_date)) {
            unique.push(out_date);
        }
    }

    checkout_dates = unique.sort(function (a, b) {
        var aa = a.split('.').reverse().join(),
            bb = b.split('.').reverse().join();
        return aa < bb ? -1 : (aa > bb ? 1 : 0);
    });

    unique = [];

    for (let i = document.getElementById("room-checkin-date").length; i >= 0; i--) {
        document.getElementById("room-checkin-date").remove(i);
    }

    for (let i = document.getElementById("room-checkout-date").length; i >= 0; i--) {
        document.getElementById("room-checkout-date").remove(i);
    }

    let option_1 = document.createElement('option');
    let text_1 = document.createTextNode('');
    option_1.appendChild(text_1);
    option_1.setAttribute('value', text_1.textContent);
    document.getElementById("room-checkin-date").appendChild(option_1);

    let departure_from_minsk = document.getElementById("departure-from-minsk").value;
    let ISO_dep_from_minsk = departure_from_minsk.substring(6) + '-' + departure_from_minsk.substring(3, 5) + '-' + departure_from_minsk.substring(0, 2);
    let dep_date = new Date(ISO_dep_from_minsk);
    let arrival_to_minsk = document.getElementById("arrival-to-minsk").value;
    let ISO_arrival_to_minsk = arrival_to_minsk.substring(6) + '-' + arrival_to_minsk.substring(3, 5) + '-' + arrival_to_minsk.substring(0, 2);
    let arr_date = new Date(ISO_arrival_to_minsk);

    for (let date of checkin_dates) {
        let ISO_date = date.substring(6) + '-' + date.substring(3, 5) + '-' + date.substring(0, 2);
        let d = new Date(ISO_date);
        if (dep_date <= d) {
            let option = document.createElement('option');
            let text = document.createTextNode(date);
            option.appendChild(text);
            option.setAttribute('value', text.textContent);
            document.getElementById("room-checkin-date").appendChild(option);
        }
    }

    let option_2 = document.createElement('option');
    let text_2 = document.createTextNode('');
    option_2.appendChild(text_2);
    option_2.setAttribute('value', '0');
    document.getElementById("room-checkout-date").appendChild(option_2);

    for (let date of checkout_dates) {
        let ISO_date = date.substring(6) + '-' + date.substring(3, 5) + '-' + date.substring(0, 2);
        let d = new Date(ISO_date);
        if (arr_date >= d && d >= dep_date) {
            let option = document.createElement('option');
            let text = document.createTextNode(date);
            option.appendChild(text);
            option.setAttribute('value', text.textContent);
            document.getElementById("room-checkout-date").appendChild(option);
        }
    }
}

async function getFreeDates() {
    let url = "/rooms/free/" + document.getElementById("hotels").value;
    let response = await fetch(url);
    if (!response.ok) {
        console.log("Не удалось получить свободные даты");
        return false;
    }

    json_dates = await response.json();

    return json_dates;
}