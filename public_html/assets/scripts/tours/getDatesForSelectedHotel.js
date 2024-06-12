const FAILED_RESPONSE = "Не удалось обновить даты заездов и выездов для поиска по турам";
const URI = "tours/getDatesForSelectedHotel/";

document.getElementById("search-hotel").addEventListener("change", function () {
    getDatesForSelectedHotel();
});

async function getDatesForSelectedHotel() {
    let hotel_id = document
        .getElementById("search-hotel")
        .value;
    let uri = URI + hotel_id;
    let response = await fetch(uri);

    if (response.ok == false) {
        alert(FAILED_RESPONSE);
        return;
    }

    let json_response = await response.json();
    let dates = json_response.dates;
    let departure_from_minsk_dates = dates.departureFromMinskDates;
    let departure_from_hotel_dates = dates.departureFromHotelDates;

    buildDatesList("search-from-minsk-date", departure_from_minsk_dates);
    buildDatesList("search-to-minsk-date", departure_from_hotel_dates);
}

function buildDatesList(id, new_dates) {
    removeDatesFromList(id);

    for (let new_date of new_dates) {
        let new_option = document.createElement('option');
        new_option.setAttribute('value', new_date);
        new_option.innerHTML = new_date;
        document.getElementById(id).appendChild(new_option);
    }
}

function removeDatesFromList(id) {
    for (let i = document.getElementById(id).length; i >= 1; i--) {
        document.getElementById(id).remove(i);
    }
}