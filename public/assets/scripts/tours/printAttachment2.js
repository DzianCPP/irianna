document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("print-attachment-2").addEventListener("click", function () {
        printAttachment2();
    });
});

async function printAttachment2() {
    window.open("/tours/printAttachmentTwo");
}