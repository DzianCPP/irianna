document.getElementById("name").addEventListener("keyup", formFilled);
document.getElementById("is-active").addEventListener("change", formFilled);

function formFilled() {
    let _name = document.getElementById("name");
    let saveBtn = document.getElementById("save-btn");
    saveBtn.disabled = true;

    if (_name.value.length > 2) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}