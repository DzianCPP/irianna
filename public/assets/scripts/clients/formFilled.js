document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("main-client-last-name").addEventListener("keyup", formFilled);
    document.getElementById("main-client-first-name").addEventListener("keyup", formFilled);
    document.getElementById("main-client-passport").addEventListener("keyup", formFilled);
    document.getElementById("main-client-phone-main").addEventListener("keyup", formFilled);
    document.getElementById("main-client-birth-date").addEventListener("click", formFilled);
});

function formFilled() {
    let _saveBtn = document.getElementById("save-btn");
    _saveBtn.disabled = true;

    let last_name = document.getElementById("main-client-last-name").value;
    let first_name = document.getElementById("main-client-first-name").value;
    let passport = document.getElementById("main-client-passport").value;
    let main_phone = document.getElementById("main-client-phone-main").value;
    let birth_date = document.getElementById("main-client-birth-date").value;

    let error = document.getElementById("error-field");

    if (last_name.length < 3) {
        _saveBtn.disabled = true;
        error.innerHTML = "Фамилия должна содержать более 3 символов";
        return;
    }

    if (first_name.length < 2) {
        _saveBtn.disabled = true;
        error.innerHTML = "Имя должно содержать более 2 символов";
        return;
    }

    if (passport.length < 7) {
        _saveBtn.disabled = true;
        error.innerHTML = "Паспорт должен содержать более 7 символов";
        return;
    }

    if (main_phone.length < 9) {
        _saveBtn.disabled = true;
        error.innerHTML = "Номер телефона должен содержать более 9 символов";
        return;
    }

    if (!birth_date) {
        _saveBtn.disabled = true;
        error.innerHTML = "Вы не заполнили дату рождения";
        return;
    }

    error.innerHTML = "";
    _saveBtn.disabled = false;
    return;
}