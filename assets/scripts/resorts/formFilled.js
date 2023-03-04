document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("name").addEventListener("keyup", formFilled);
    document.getElementById("country").addEventListener("click", formFilled);
    document.getElementById("is-active").addEventListener("click", formFilled);
    document.body.addEventListener("mouseover", formFilled);
});

function formFilled() {
    document.getElementById('save-btn').disabled = true;

    let length = document.getElementById("name").value.length;
    let contains_digits = /\d/.test(document.getElementById("name").value);

    if (length > 2 && contains_digits != true) {
        document.getElementById("save-btn").disabled = false;
    } else {
        document.getElementById("save-btn").disabled = true;
    }
}