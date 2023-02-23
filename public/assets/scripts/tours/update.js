document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-tour").addEventListener("click", function () {
        update();
    });
});

async function update() {
    let __delete = await _delete();

    if (!__delete) {
        var _alert = document.getElementById("alert");
        _alert.setAttribute('class', 'alert alert-danger mt-2');
        _alert.innerHTML = 'Тур не удалось сохранить';
        _alert.hidden = false;
        return;
    }

    let _create = await create();

    if (!_create) {
        var _alert = document.getElementById("alert");
        _alert.setAttribute('class', 'alert alert-danger mt-2');
        _alert.innerHTML = 'Тур не удалось обновить';
        _alert.hidden = false;
        return;
    }

    console.log("Тур обновлен");

    var _alert = document.getElementById("alert");
    _alert.setAttribute('class', 'alert alert-success mt-2');
    _alert.innerHTML = 'Тур обновлен';
    _alert.hidden = false;
}

async function _delete() {
    let tour_id = document.getElementById("tour-id").innerHTML;
    let url = "/tours/delete";
    let DELETE = {
        method: 'DELETE',
        body: JSON.stringify([tour_id])
    };

    let response = await fetch(url, DELETE);

    if (!response.ok) {
        return false;
    }

    return true;
}

async function create() {
    let ifClientReady = await createClient();

    if (ifClientReady) {
        let lastClientId = await getLastClientId();
        console.log(lastClientId);

        let url = "/tours/create";
        let _manager_id = document.getElementById("manager").value;
        let _only_transit = document.getElementById("only-transit");
        let _resort_id = document.getElementById("resort").value;
        let _hotel_id = document.getElementById("hotels").value;
        let _room_id = document.getElementById("rooms").value;
        let _bus_id = document.getElementById("bus-to").value;
        let _departure_from_minsk = document.getElementById("departure-from-minsk").value;
        let _bus_back_id = document.getElementById("bus-from").value;
        let _departure_from_resort = document.getElementById("room-checkout-date").value;
        let _created = new Date();

        let tour = {
            created: _created.getDay() + "-" + _created.getMonth() + "-" + _created.getFullYear(),
            manager_id: _manager_id,
            is_only_transit: Number(_only_transit.checked),
            transit: document.getElementById("transits").value,
            resort_id: _resort_id,
            hotel_id: _hotel_id,
            checkin_date: document.getElementById("room-checkin-date").value,
            checkout_date: document.getElementById("room-checkout-date").value,
            count_of_day: 7,
            bus_id: _bus_id,
            owner_id: await getLastClientId(),
            owner_travel_service: document.getElementById("main-client-service-cost").value,
            owner_travel_cost: document.getElementById("main-client-tour-cost").value + " " + document.getElementById("main-client-currency-1").value,
            number_of_children: document.getElementById("number-of-children").value,
            ages: document.getElementById("age-of-children").value,
            total_travel_service_byn: document.getElementById("total-service-cost").innerHTML,
            total_travel_cost_byn: document.getElementById("total-tour-cost").innerHTML + " " + document.getElementById("total-currency-1").innerHTML,
            total_travel_service_currency: document.getElementById("total-cost-currency").innerHTML + " " + document.getElementById("total-currency").innerHTML,
            total_travel_cost_currency: document.getElementById("total-cost-currency").innerHTML + " " + document.getElementById("total-currency").innerHTML,
            from_minsk_date: _departure_from_minsk,
            to_minsk_date: _departure_from_resort,
            arrival_to_minsk: document.getElementById("arrival-to-minsk").value,
            room_id: document.getElementById("rooms").value
        };

        let POST = {
            method: "POST",
            body: JSON.stringify(tour)
        };

        let response = await fetch(url, POST);

        if (response.ok) {
            console.log("Тур сохранен");
            return true;
        } else {
            console.log("Тур не удалось сохранить");
            return false;
        }
    }
}

async function createClient() {
    let url = "/clients/create";
    let clients = getClients();

    let POST = {
        method: "POST",
        body: JSON.stringify(clients)
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        console.log("Новый клиент создан");
        return true;
    } else {
        alert("Что-то пошло не так");
        return false;
    }
}

async function getLastClientId() {
    let url = "/clients/last";
    let POST = {
        method: "POST"
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        console.log("Ответ получен");
        let id = await response.json();
        return id;
    } else {
        console.log("Произошла ошибка при получении ответа");
    }
}

function getClients() {
    let clients = {
        main_client: getMainClient(),
        sub_client: getSubClients()
    };

    return clients;
}

function getMainClient() {
    let _name = document.getElementById("main-client-name").value;
    let _mainPhone = document.getElementById("main-client-phone-main").value;
    let _secondPhone = document.getElementById("main-client-phone-second").value;
    let _passport = document.getElementById("main-client-passport").value;
    let _birthDate = document.getElementById("main-client-birth-date").value;
    let _address = document.getElementById("main-client-address").value;
    let _travel_service = document.getElementById("main-client-service-cost").value;
    let _travel_cost_currency_1 = document.getElementById("main-client-tour-cost").value + " " + document.getElementById("main-client-currency-1").value;
    let _travel_cost_currency_2 = document.getElementById("main-client-total-cost-currency").value + " " + document.getElementById("main-client-currency").value;

    return {
        name: _name,
        main_phone: _mainPhone,
        second_phone: _secondPhone,
        passport: _passport,
        birthday: _birthDate,
        address: _address,
        travel_service: _travel_service,
        travel_cost_currency_1: _travel_cost_currency_1,
        travel_cost_currency_2: _travel_cost_currency_2
    };
}

function getSubClients() {
    let names = [];
    let passports = [];
    let birthDates = [];
    let travel_services = [];
    let travel_cost_currency_1 = [];
    let travel_cost_currency_2 = [];

    for (var el of document.getElementsByName("sub-client-name")) {
        names.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-passport")) {
        passports.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-birth-date")) {
        birthDates.push(el.value);
    }

    for (var el of document.getElementsByName("sub-service-cost")) {
        travel_services.push(el.value);
    }

    for (var el of document.getElementsByName("sub-tour-cost")) {
        travel_cost_currency_1.push(el.value + " " + document.getElementById("main-client-currency-1").value);
    }

    for (var el of document.getElementsByName("sub-tour-cost-currency")) {
        travel_cost_currency_2.push(el.value + " " + document.getElementById("main-client-currency").value);
    }

    return {
        _names: names,
        _passport: passports,
        _birthDates: birthDates,
        _travel_services: travel_services,
        _travel_cost_currency_1s: travel_cost_currency_1,
        _travel_cost_currency_2s: travel_cost_currency_2
    };
}