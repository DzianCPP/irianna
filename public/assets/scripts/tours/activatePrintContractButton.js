document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-tour").addEventListener("focusout", function () {
        if (document.getElementById("save-tour").disabled == false) {
            let print_contract_btn = document.getElementById("print-contract");
            print_contract_btn.disabled = false;

            let print_attachement_2 = document.getElementById("print-attachment-2");
            print_attachement_2.disabled = false;

            let print_voucher = document.getElementById("print-voucher");
            print_voucher.disabled = false;
        }
    });
});