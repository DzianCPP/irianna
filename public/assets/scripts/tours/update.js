document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-tour").addEventListener("click", function () { update(); });
});

async function update() {
    let updateSubClientsResponse = await updateSubClients();

    if (!updateSubClientsResponse) {
        console.log("Что-то пошло не так!");
        document.getElementById("error-field").innerHTML = "Что-то пошло не так!";
        alert("Что-то пошло не так!");
        return;
    }

    let updateMainClientResponse = await updateMainClient();

    if (!updateMainClientResponse) {
        console.log("Что-то пошло не так!");
        document.getElementById("error-field").innerHTML = "Что-то пошло не так!";
        alert("Что-то пошло не так!");
        return;
    }

    let url = "/tours/update";
    let tour = getTour();

    let PUT = {
        method: 'PUT',
        body: JSON.stringify(tour)
    };

    let response = await fetch(url, PUT);

    if (!response.ok) {
        console.log("Ошибка на сервере");
        document.getElementById("error-field").innerHTML = "Что-то пошло не так";
        return;
    } else {
        window.location = "/tours";
    }
}








async function updateSubClients() {
    let url = "/clients/updateSubClients";
    let sub_clients = getSubClients();

    let PUT = {
        method: "PUT",
        body: JSON.stringify(sub_clients)
    };

    let response = await fetch(url, PUT);

    if (response.ok == false) {
        return false;
    }

    return true;
}

async function updateMainClient() {
    let url = "/clients/update";
    let main_client = getMainClient();

    let PUT = {
        method: "PUT",
        body: JSON.stringify(main_client)
    };

    let response = await fetch(url, PUT);

    if (response.ok != false) {
        return true;
    }

    return false;
}

function getSubClients() {
    let lastNames = [];
    let firstNames = [];
    let secondNames = [];
    let passports = [];
    let birthDates = [];
    let ids = [];
    let main_client_ids = [];

    for (var el of document.getElementsByName("sub-client-last-name")) {
        lastNames.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-first-name")) {
        firstNames.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-second-name")) {
        secondNames.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-passport")) {
        passports.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-birth-date")) {
        birthDates.push(el.value);
    }

    for (var el of document.getElementsByName("sub-client-id")) {
        ids.push(el.innerHTML);
    }

    let names = [];

    for (var i = 0; i < lastNames.length; i++) {
        names.push(lastNames[i] + " " + firstNames[i] + " " + secondNames[i]);
    }

    for (var el of document.getElementsByName("main-client-id")) {
        main_client_ids.push(el.innerHTML);
    }

    return {
        _names: names,
        _passport: passports,
        _birthDates: birthDates,
        _ids: ids,
        _main_client_ids: main_client_ids
    };
}

function getMainClient() {
    let _lastName = document.getElementById("main-client-last-name").value;
    let _firstName = document.getElementById("main-client-first-name").value;
    let _secondName = document.getElementById("main-client-second-name").value;
    let _mainPhone = document.getElementById("main-client-phone-main").value;
    let _secondPhone = document.getElementById("main-client-phone-second").value;
    let _passport = document.getElementById("main-client-passport").value;
    let _birthDate = document.getElementById("main-client-birth-date").value;
    let _address = document.getElementById("main-client-address").value;
    let _id = document.getElementById("client-id").innerHTML;

    return {
        name: _lastName + " " + _firstName + " " + _secondName,
        main_phone: _mainPhone,
        second_phone: _secondPhone,
        passport: _passport,
        birth_date: _birthDate,
        address: _address,
        id: _id
    };
}

function getTour() {
    let _manager_id = document.getElementById("manager").value;
    let _only_transit = document.getElementById("only-transit");
    let _resort_id = document.getElementById("resort").value;
    let _hotel_id = document.getElementById("hotels").value;
    let _room_id = document.getElementById("rooms").value;
    let _bus_id = document.getElementById("bus-to").value;
    let _departure_from_minsk = document.getElementById("departure-from-minsk").value;
    let _departure_from_resort = document.getElementById("departure-from-resort").value;
    let _created = new Date();

    return {
        created: _created.getDay() + "-" + _created.getMonth() + "-" + _created.getFullYear(),
        manager_id: Number(_manager_id),
        is_only_transit: Number(_only_transit.checked),
        transit: document.getElementById("transits").value,
        resort_id: _resort_id,
        hotel_id: _hotel_id,
        checkin_date: _departure_from_minsk,
        checkout_date: _departure_from_resort,
        count_of_days: 7,
        bus_id: _bus_id,
        owner_id: Number(document.getElementById("client-id").innerHTML),
        owner_travel_service: document.getElementById("main-client-service-cost").value,
        owner_travel_cost: document.getElementById("main-client-tour-cost").value,
        number_of_children: document.getElementById("number-of-children").value,
        ages: document.getElementById("age-of-children").value,
        total_travel_service_byn: document.getElementById("total-service-cost").innerHTML,
        total_travel_cost_byn: document.getElementById("total-tour-cost").innerHTML,
        total_travel_service_currency: document.getElementById("total-cost-currency").innerHTML + " " + document.getElementById("total-currency").innerHTML,
        total_travel_service_currency: document.getElementById("total-cost-currency").innerHTML + " " + document.getElementById("total-currency").innerHTML,
        from_minsk_date: _departure_from_minsk,
        to_minsk_date: _departure_from_resort,
        room_id: document.getElementById("rooms").value,
        id: Number(document.getElementById("tour-id").innerHTML)
    };
}