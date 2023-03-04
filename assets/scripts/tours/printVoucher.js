document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("print-voucher").addEventListener("click", function () {
        printVoucher();
    });
});

async function printVoucher() {
    window.open("/tours/printVoucher/" + document.getElementById("tour-to-print-id").innerHTML);
}