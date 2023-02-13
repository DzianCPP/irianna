document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("find-tour").addEventListener("click", function () {
        searchTours();
    });
});

function searchTours() {    
    let hotel_id = document.getElementById("search-hotel").value;
    let bus_id = document.getElementById("search-bus").value;
    let from_minsk_date = document.getElementById("search-from-minsk-date").value;
    let to_minsk_date = document.getElementById("search-to-minsk-date").value;
    let name = document.getElementById("search-name").value;

    let url = "/tours/search/params";

    if (hotel_id != 0) {
        url += "/hotel_id=" + hotel_id;
    }

    if (bus_id != 0) {
        url += "/bus_id=" + bus_id;
    }

    if (from_minsk_date != 0) {
        url += "/from_minsk_date=" + from_minsk_date;
    }

    if (to_minsk_date != 0) {
        url += "/to_minsk_date=" + to_minsk_date;
    }

    if (name != '') {
        url += "/name=" + name;
    }

    window.location = url;
}