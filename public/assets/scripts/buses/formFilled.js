document.getElementById("name-1").addEventListener("keyup", formFilled1);
document.getElementById("route-1").addEventListener("keyup", formFilled1);
document.getElementById("places-1").addEventListener("keyup", formFilled1);


function formFilled1() {
    let _name = document.getElementById("name-1");
    let _route = document.getElementById("route-1");
    let _places = document.getElementById("places-1");
    let saveBtn = document.getElementById("save-btn-1");

    if (_name.value.length > 2 && _route.value.length > 2 && _places.value.length > 1) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}

document.getElementById("name-2").addEventListener("keyup", formFilled2);
document.getElementById("route-2").addEventListener("keyup", formFilled2);
document.getElementById("places-2").addEventListener("keyup", formFilled2);


function formFilled2() {
    let _name = document.getElementById("name-2");
    let _route = document.getElementById("route-2");
    let _places = document.getElementById("places-2");
    let saveBtn = document.getElementById("save-btn-2");

    if (_name.value.length > 2 && _route.value.length > 2 && _places.value.length > 1) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}

document.getElementById("name-3").addEventListener("keyup", formFilled3);
document.getElementById("route-3").addEventListener("keyup", formFilled3);
document.getElementById("places-3").addEventListener("keyup", formFilled3);


function formFilled3() {
    let _name = document.getElementById("name-3");
    let _route = document.getElementById("route-3");
    let _places = document.getElementById("places-3");
    let saveBtn = document.getElementById("save-btn-3");

    if (_name.value.length > 2 && _route.value.length > 2 && _places.value.length > 1) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}