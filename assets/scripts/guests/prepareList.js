document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("prepare-list").addEventListener("click", function () {
        prepareList();
    });
});

async function prepareList() {
    let url = "/clients/hotel_list";
    let info = {
        hotel_id: document.getElementById("hotel").value,
        checkin_date: document.getElementById("checkin-date").value,
        checkout_date: document.getElementById("checkout-date").value
    };

    let POST = {
        method: 'POST',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (!response.ok) {
        console.log("Ошибка! Не удалось найти пассажиров");
        alert("Ошибка!");
        return;
    } else {
        window.location = "/clients/guests_list";
    }
}