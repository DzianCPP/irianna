document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-tour").addEventListener("click", function () {
        let print_contract_btn = document.getElementById("print-contract");
        print_contract_btn.disabled = false;
    });
});