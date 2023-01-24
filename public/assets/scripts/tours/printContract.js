document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("print-contract").addEventListener("click", function () {
        printContract();
    });
});

function printContract() {
    window.location = "/tours/printContract";
}