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
    formData.append('name', document.getElementById("document-name").value);

    let POST = {
        method: 'POST',
        body: formData
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        console.log("Файл успешно загружен");
        window.location = "/contracts";
    } else {
        document.getElementById("error-field").innerHTML = "Что-то пошло не так";
        return;
    }
}