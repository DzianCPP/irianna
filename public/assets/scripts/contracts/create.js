document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        create();
    });
});

async function create() {
    let file = document.getElementById("formFile").files[0];
    let url = "/contracts/create";
    
    let formData = new FormData();

    formData.append('file', file);

    let POST = {
        method: 'POST',
        body: formData
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        console.log("Файл успешно загружен");
        sendLabel();
    } else {
        document.getElementById("error-field").innerHTML = "Что-то пошло не так";
        return;
    }
}

async function sendLabel() {
    let _label = document.getElementById("document-label").value;
    let url = "/contracts/addLabel";

    let info = { label: _label };

    let POST = { method: 'POST', body: JSON.stringify(info) };

    let response = await fetch(url, POST);

    if (response.ok) {
        console.log("Документ получил тип");
        window.location = "/contracts";
    } else {
        console.log("Не удалось закрепить тип за документом");
        document.getElementById("error-field").innerHTML = "Что-то пошло не так";
        return;
    }
}