document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("prepare-statement").addEventListener("click", function () {
        prepareStatement();
    });
});

async function prepareStatement() {
    let url = "/statement/prepare";
    let info = {
        bus_id: document.getElementById("bus").value,
        from_minsk_date: document.getElementById("from-minsk-date").value,
        to_minsk_date: document.getElementById("to-minsk-date").value
    };

    let POST = {
        method: 'POST',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, POST);

    if (!response.ok) {
        console.log("Ошибка! Не удалось подготовить ведомость");
        alert("Ошибка!");
        return;
    } else {
        window.location = "/statement/doc";
    }
}