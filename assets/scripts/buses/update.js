document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        update();
    });
});

async function update() {
    let url = "/buses/update";

    let response = await fetch(url, {
        method: "PUT",
        body: JSON.stringify({
            name: document.getElementById("name").value,
            route: document.getElementById("route").value,
            places: document.getElementById("places").value,
            departure_from_minsk: document.getElementById("from-minsk").value.trim()+"\n",
            arrival_to_minsk: document.getElementById("to-minsk").value.trim()+"\n",
            id: document.getElementById("bus-id").innerHTML
        })
    });

    if (response.ok != false) {
        window.location = "/buses";
    } else {
        alert("Что-то пошло не так");
    }
}