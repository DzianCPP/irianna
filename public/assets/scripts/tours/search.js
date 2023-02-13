document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("find-tour").addEventListener("click", function () {
        searchTours();
    });
});

async function searchTours() {    
    let hotel_id = document.getElementById("search-hotel").value;
    let bus_id = document.getElementById("search-bus").value;
    let from_minsk_date = String(document.getElementById("search-from-minsk-date").value);
    let to_minsk_date = String(document.getElementById("search-to-minsk-date").value);
    let name = String(document.getElementById("search-name").value);

    let url = "/tours/search";

    let params = {};

    if (hotel_id != 0) {
        Object.defineProperty(params, 'hotel_id', { value: hotel_id, writable: true, enumerable: true });
    }

    if (bus_id != 0) {
        Object.defineProperty(params, 'bus_id', { value: bus_id, enumerable: true });
    }

    if (from_minsk_date != 0) {
        Object.defineProperty(params, 'from_minsk_date', { value: from_minsk_date, enumerable: true });
    }

    if (to_minsk_date != 0) {
        Object.defineProperty(params, 'to_minsk_date', { value: to_minsk_date, enumerable: true });
    }

    if (name != '') {
        Object.defineProperty(params, 'name', { value: name, enumerable: name });
    }

    if (Object.keys(params).length == 0) {
        alert("Вы не задали ни одного параметра");
        return;
    }

    let POST = { method: 'POST', body: JSON.stringify(params) };

    let response = await fetch (url, POST);

    if (!response.ok) {
        alert("Ошибка! Не удалось выполнить поиск!");
        return;
    }

    let data = await response.json();

    if (data.message == 'No such tours') {
        alert("Нет туров, подходящих под заданные параметры");
        return;
    }

    renderTable(data.tours);
}

function renderTable(tours) {
    let table = document.getElementById("table");
}