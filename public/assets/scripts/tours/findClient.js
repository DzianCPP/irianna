document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("find-client").addEventListener("click", function () {
        findClient();
    });
});

async function findClient() {
    let passport = document.getElementById("main-client-passport").value;
    let url = "/clients/find";
    let POST = {
        method: "POST",
        body: JSON.stringify(passport)
    };

    let response = await fetch(url, POST);

    if (response.ok == false) {
        alert("Что-то пошло не так");
    } else {
        let client = await response.json();
        document.getElementById("main-client-last-name").value = client.name.split(" ")[0];
        document.getElementById("main-client-first-name").value = client.name.split(" ")[1];
        document.getElementById("main-client-second-name").value = client.name.split(" ")[2];
        document.getElementById("main-client-phone-main").value = client.main_phone;
        document.getElementById("main-client-phone-second").value = client.second_phone;
        document.getElementById("main-client-birth-date").value = client.birth_date;
        document.getElementById("main-client-address").value = client.address;
    }
}