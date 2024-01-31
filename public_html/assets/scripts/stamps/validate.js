document
.addEventListener(
    "mouseover",
    () => { validate() }
);

function validate() {
    let filesLength = document.getElementById("stamp-file").files.length;

    if (filesLength >= 1) {
        let saveBtn = document.getElementById("save-btn");

        saveBtn.disabled = false;
    }
}