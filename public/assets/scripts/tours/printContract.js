document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("print-contract").addEventListener("click", function () {
        printTour();
    });
});

async function printTour() {
    window.location = "/tours/printContract";
}