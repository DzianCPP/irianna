document.addEventListener("DOMContentLoaded", function() {
    let contract = document.getElementById("contract-html").innerHTML;
    if (contract) {
        document.getElementById("text-input").innerHTML = contract;
    }
})