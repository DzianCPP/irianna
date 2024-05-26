document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("keypress", function (event) {
        if (event.keyCode === 13) {
            document.getElementById("find-tour").click();
        }
    });
});