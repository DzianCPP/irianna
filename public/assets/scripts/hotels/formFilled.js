document.getElementById("name-1").addEventListener("keyup", formFilled1);
document.getElementById("resort-id-1").addEventListener("change", formFilled1);
document.getElementById("is-active-1").addEventListener("change", formFilled1);


function formFilled1() {
    let _name = document.getElementById("name-1");
    let saveBtn = document.getElementById("save-btn-1");

    if (_name.value.length > 2) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}

document.getElementById("name-2").addEventListener("keyup", formFilled2);
document.getElementById("resort-id-2").addEventListener("change", formFilled2);
document.getElementById("is-active-2").addEventListener("change", formFilled2);


function formFilled2() {
    let _name = document.getElementById("name-2");
    let saveBtn = document.getElementById("save-btn-2");

    if (_name.value.length > 2) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}

document.getElementById("name-3").addEventListener("keyup", formFilled3);
document.getElementById("resort-id-3").addEventListener("change", formFilled3);
document.getElementById("is-active-3").addEventListener("change", formFilled3);


function formFilled3() {
    let _name = document.getElementById("name-3");
    let saveBtn = document.getElementById("save-btn-3");

    if (_name.value.length > 2) {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}