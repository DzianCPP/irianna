document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("print-contract").addEventListener("click", function () {
        printTour();
    });
});

async function printTour() {
    window.open("/tours/printContract/" + document.getElementById("tour-to-print-id").innerHTML);
}