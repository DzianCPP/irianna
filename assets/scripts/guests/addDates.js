document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotel").addEventListener("change", function () {
        addDates();
    });
});

function addDates() {
    let rooms_sets = JSON.parse(document.getElementById("rooms-sets").innerHTML);
    for (let i = document.getElementById("checkin-date").length; i >= 0; i--) {
        document.getElementById("checkin-date").remove(i);
    }

    for (let i = document.getElementById("checkout-date").length; i >= 0; i--) {
        document.getElementById("checkout-date").remove(i);
    }
    let checkin_dates = [];
    let checkout_dates = [];

    for (let rooms of rooms_sets) {
        for (let room of rooms) {
            if (room.hotel_id == document.getElementById("hotel").value) {

                for (let i = 0; i < room.checkin_checkout_dates.length; i+=2) {
                    checkin_dates.push(room.checkin_checkout_dates[i].substr(1));
                    checkout_dates.push(room.checkin_checkout_dates[i+1].substr(1));
                }
                console.log(room.hotel_id)
            }
        }
    }

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