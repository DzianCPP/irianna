document.getElementById("name").addEventListener("keyup", formFilled);
document.getElementById("resort-id").addEventListener("click", formFilled);
document.getElementById("is-active").addEventListener("click", formFilled);
document.getElementById("rooms").addEventListener("keyup", formFilled);
document.getElementById("rooms").addEventListener("click", formFilled);


function formFilled() {
    let _name = document.getElementById("name");
    let _resort_id = document.getElementById("resort-id");
    let _rooms = document.getElementById("rooms");
    let _is_active = document.getElementById("is-active");
    let saveBtn = document.getElementById("save-btn");
    let _error_field = document.getElementById("error-field");

    saveBtn.disabled = true;

    if (_name.value.length < 2) {
        saveBtn.disabled = true;
        _error_field.innerHTML = "Введите название гостиницы";
        return;
    }

    if (isNaN(_resort_id.value)) {
        saveBtn.disabled = true;
        _error_field.innerHTML = "Выберите курорт";
        return;
    }

    if (isNaN(_rooms.value)) {
        saveBtn.disabled = true;
        _error_field.innerHTML = "Введите количетсов комнат ЧИСЛОВЫМ значением";
        return;
    }

    if (_rooms.value.length < 1) {
        saveBtn.disabled = true;
        _error_field.innerHTML = "Введите количетсов комнат";
        return;
    }

    if (_rooms.value < 1) {
        saveBtn.disabled = true;
        _error_field.innerHTML = "Количество комнат не может быть меньше 1";
        return;
    }

    _error_field.innerHTML = "";
    saveBtn.disabled = false;
}