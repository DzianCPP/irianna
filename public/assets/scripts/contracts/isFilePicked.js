document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formFile").addEventListener("change", function () {
        isFilePicked();
    });
});

function isFilePicked() {
    let formFile = document.getElementById("formFile");
    let saveBtn = document.getElementById("save-btn");
    saveBtn.disabled = true;

    if (formFile.files) {
        console.log("Файл загружен в браузер");
        saveBtn.disabled = false;
    } else {
        console.log("Файл не удалось загрузить");
        saveBtn.disabled = false;
    }
}