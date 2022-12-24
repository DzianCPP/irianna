document.getElementById("last-name").addEventListener("keyup", formFilled);
document.getElementById("second-name").addEventListener("keyup", formFilled);
document.getElementById("first-name").addEventListener("keyup", formFilled);

function formFilled() {
    let lName = document.getElementById("last-name").value.length;
    let fName = document.getElementById("first-name").value.length;
    let sName = document.getElementById("second-name").value.length;
    let saveBtn = document.getElementById("save-btn");

    saveBtn.disabled = true;

    if (lName + fName + sName >= 6) {
        saveBtn.disabled = false;
    }
}