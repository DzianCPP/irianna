document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        create();
    });
});

async function create() {
    let url = "/clients/create";
    let clients = getClients();

    let POST = {
        method: "POST",
        body: JSON.stringify(clients)
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        window.location = "/clients";
    } else {
        alert("Что-то пошло не так");
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
    let _lastName = document.getElementById("main-client-last-name").value;
    let _firstName = document.getElementById("main-client-first-name").value;
    let _secondName = document.getElementById("main-client-second-name").value;
    let _mainPhone = document.getElementById("main-client-phone-main").value;
    let _secondPhone = document.getElementById("main-client-phone-second").value;
    let _passport = document.getElementById("main-client-passport").value;
    let _birthDate = document.getElementById("main-client-birth-date").value;
    let _address = document.getElementById("main-client-address").value;

    return {
        name: _lastName + " " + _firstName + " " + _secondName,
        main_phone: _mainPhone,
        second_phone: _secondPhone,
        passport: _passport,
        birthday: _birthDate,
        address: _address
    };
}

function getSubClients() {
    let lastNames = [];
    let firstNames = [];
    let secondNames = [];
    let passports = [];
    let birthDates = [];

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
    
    return {
        _lastNames: lastNames,
        _firstNames: firstNames,
        _secondNames: secondNames,
        _passport: passports,
        _birthDates: birthDates
    };
}