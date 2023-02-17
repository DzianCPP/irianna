document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("resort").addEventListener("change", function () {
        reset();
    });
});

function reset() {
    let bus_to = document.getElementById("bus-to");
    let bus_from = document.getElementById("bus-from");
    let dep = document.getElementById("departure-from-minsk");
    let arrival = document.getElementById("arrival-to-minsk");
    let checkin = document.getElementById("room-checkin-date");
    let checkout = document.getElementById("room-checkout-date");
    let room = document.getElementById("rooms");
    for (var o of bus_to) {
        if (o.value == 0) {
            o.selected = 'selected';
        }
    }

    for (var o of bus_from) {
        if (o.value == 0) {
            o.selected = 'selected';
        }
    }

    for (var o of dep) { if (o.value == 0) { o.selected = 'selected'; } }
    for (var o of arrival) { if (o.value == 0) { o.selected = 'selected'; } }
    for (var o of checkin) { if (o.value == 0) { o.selected = 'selected'; } }
    for (var o of checkout) { if (o.value == 0) { o.selected = 'selected'; } }
    for (var o of rooms) { if (o.value == 0) { o.selected = 'selected'; } }
}