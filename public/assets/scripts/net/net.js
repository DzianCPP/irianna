document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("hotels-btn").addEventListener("click", function () {
        let url = "/net/" + document.getElementById("hotels").value;
        window.location = url;
    })
})