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

    alert("OK");
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