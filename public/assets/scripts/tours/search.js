document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("find-tour").addEventListener("click", function () {
        searchTours();
    });
});

function searchTours() {
    let params = {};
    let url = "/tours/search";
    
    let hotel_id = document.getElementById("search-hotel").value;
    let bus_id = document.getElementById("search-bus").value;
    let from_minsk_date = document.getElementById("search-from-minsk-date").value;
    let to_minsk_date = document.getElementById("search-to-minsk-date").value;
    let name = document.getElementById("search-name").value;

    let info = {
        hotel_id: hotel_id,
        bus_id: bus_id,
        from_minsk_date: from_minsk_date,
        to_minsk_date: to_minsk_date,
        name: name
    };

    fetch(url, {method: 'POST', body: JSON.stringify(info)});
}