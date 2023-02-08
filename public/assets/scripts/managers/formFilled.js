document.getElementById("name").addEventListener("keyup", formFilled);
document.body.addEventListener("mouseover", formFilled);

function formFilled() {
    let _name = document.getElementById("name").value.length;
    let saveBtn = document.getElementById("save-btn");

    saveBtn.disabled = true;

    if (_name >= 6) {
        saveBtn.disabled = false;
    }
}