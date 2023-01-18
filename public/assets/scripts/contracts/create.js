document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", function () {
        create();
    });
});

async function create() {
    let file = document.getElementById("formFile").files[0];
    let url = "/contracts/create";
    let fileName = file.name;
    
    let formData = new FormData();

    formData.append('file', file);

    let POST = {
        method: 'POST',
        body: formData
    };

    let response = await fetch(url, POST);

    if (response.ok != false) {
        console.log("Файл успешно загружен");
        console.log(await response.json());
        // window.location = "/contracts";
    } else {
        document.getElementById("error-field").innerHTML = "Что-то пошло не так";
        return;
    }
}