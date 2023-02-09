document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        create();
    });
});

async function create() {
    let url = "/buses/create";
    let _name = document.getElementById("name").value;
    let _route = document.getElementById("route").value;
    let _places = document.getElementById("places").value;
    let _from_minsk = document.getElementById("from-minsk").value.trim()+"\n";
    let _to_minsk = document.getElementById("to-minsk").value.trim()+"\n";

    let info = {
        name: _name,
        route: _route,
        places: _places,
        departure_from_minsk: _from_minsk,
        arrival_to_minsk: _to_minsk
    };

    let POST = {
        method: "POST",
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        window.location = "/buses";
    } else {
        alert("Что-то пошло не так");
    }
}