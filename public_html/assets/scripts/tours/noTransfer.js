document.addEventListener("DOMContentLoaded", function () {
    this.getElementById("transits").addEventListener("click", function () {
        noTransfer();
    });
});

function noTransfer() {
    let transits = document.getElementById("transits").value;

    if (transits == "3") {
        document.getElementById("bus-to").disabled = true;
        document.getElementById("bus-from").disabled = true;
        document.getElementById("departure-from-minsk").disabled = true;
        document.getElementById("arrival-to-minsk").disabled = true;
        document.getElementById("save-tour").disabled = false;
    } else {
        document.getElementById("bus-to").disabled = false;
        document.getElementById("bus-from").disabled = false;
        document.getElementById("departure-from-minsk").disabled = false;
        document.getElementById("arrival-to-minsk").disabled = false;
        document.getElementById("save-tour").disabled = true;
    }
}