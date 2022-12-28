document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("name").addEventListener("keyup", formFilled);
    document.getElementById("country").addEventListener("click", formFilled);
    document.getElementById("is-active").addEventListener("click", formFilled);
});

function formFilled() {
    if (document.getElementById("name").value.length > 0) {
        document.getElementById("save-btn").disabled = false;
    } else {
        document.getElementById("save-btn").disabled = true;
    }
}