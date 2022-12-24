document.getElementById("name-1").addEventListener("keyup", formFilled1);

function formFilled1() {
    var _name1 = document.getElementById("name-1");
    var saveBtn1 = document.getElementById("save-btn-1");
    saveBtn1.disabled = true;

    if (_name1.value.length > 2) {
        saveBtn1.disabled = false;
    } else {
        saveBtn1.disabled = true;
    }    
}

document.getElementById("name-2").addEventListener("keyup", formFilled2);

function formFilled2() {
    var _name2 = document.getElementById("name-2");
    var saveBtn2 = document.getElementById("save-btn-2");
    saveBtn2.disabled = true;

    if (_name2.value.length > 2) {
        saveBtn2.disabled = false;
    } else {
        saveBtn2.disabled = true;
    }    
}

document.getElementById("name-3").addEventListener("keyup", formFilled3);

function formFilled3() {
    var _name3 = document.getElementById("name-3");
    var saveBtn3 = document.getElementById("save-btn-3");
    saveBtn3.disabled = true;

    if (_name3.value.length > 2) {
        saveBtn3.disabled = false;
    } else {
        saveBtn3.disabled = true;
    }    
}

document.getElementById("name-4").addEventListener("keyup", formFilled4);

function formFilled4() {
    var _name4 = document.getElementById("name-4");
    var saveBtn4 = document.getElementById("save-btn-4");
    saveBtn4.disabled = true;

    if (_name4.value.length > 2) {
        saveBtn4.disabled = false;
    } else {
        saveBtn4.disabled = true;
    }    
}

document.getElementById("name-5").addEventListener("keyup", formFilled5);

function formFilled5() {
    var _name5 = document.getElementById("name-5");
    var saveBtn5 = document.getElementById("save-btn-5");
    saveBtn5.disabled = true;

    if (_name5.value.length > 2) {
        saveBtn5.disabled = false;
    } else {
        saveBtn5.disabled = true;
    }    
}