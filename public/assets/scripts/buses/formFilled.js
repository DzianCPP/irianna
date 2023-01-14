document.getElementById("name").addEventListener("keyup", formFilled);
document.getElementById("route").addEventListener("keyup", formFilled);
document.getElementById("places").addEventListener("keyup", formFilled);


function formFilled() {
    let _name = document.getElementById("name");
    let _route = document.getElementById("route");
    let _places = document.getElementById("places");
    let saveBtn = document.getElementById("save-btn");

    if (_name.value.length > 2 && _route.value.length > 2 && _places.value.length > 1) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}