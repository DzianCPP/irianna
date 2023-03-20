document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("only-transit").addEventListener("change", function () {
        setOnlyTransit();
    });
});

function setOnlyTransit() {
    let only_transit = document.getElementById("only-transit").checked;
    if (only_transit) {
        let only_transit_option = document.createElement('option');
        let option_text = document.createTextNode('---');
        only_transit_option.setAttribute('selected', 'true');
        only_transit_option.setAttribute('value', 'only-transit');
        only_transit_option.appendChild(option_text);
        document.getElementById("hotels").appendChild(only_transit_option);
        document.getElementById("hotels").disabled = true;

        let checkin_date_option = document.createElement('option');
        let checkin_date_option_text = document.createTextNode('---');
        checkin_date_option.setAttribute('selected', 'true');
        checkin_date_option.setAttribute('value', 'only-transit');
        checkin_date_option.appendChild(checkin_date_option_text);
        document.getElementById("room-checkin-date").appendChild(checkin_date_option);
        document.getElementById("room-checkin-date").disabled = true;

        let checkout_date_option = document.createElement('option');
        let checkout_date_option_text = document.createTextNode('---');
        checkout_date_option.setAttribute('selected', 'true');
        checkout_date_option.setAttribute('value', 'only-transit');
        checkout_date_option.appendChild(checkout_date_option_text);
        document.getElementById("room-checkout-date").appendChild(checkout_date_option);
        document.getElementById("room-checkout-date").disabled = true;

        let rooms_option = document.createElement('option');
        let rooms_option_text = document.createTextNode('---');
        rooms_option.setAttribute('selected', 'true');
        rooms_option.setAttribute('value', 'only-transit');
        rooms_option.appendChild(rooms_option_text);
        document.getElementById("rooms").appendChild(rooms_option);
        document.getElementById("rooms").disabled = true;

        return;
    }

    if (!only_transit) {
        let hotels_select = document.getElementById("hotels");
        hotels_select.disabled = false;

        let checkin_date_select = document.getElementById("room-checkin-date");
        checkin_date_select.disabled = false;
    
        let checkout_date_select = document.getElementById("room-checkout-date");
        checkout_date_select.disabled = false;

        let rooms_select = document.getElementById("rooms");
        rooms_select.disabled = false;
    }
}