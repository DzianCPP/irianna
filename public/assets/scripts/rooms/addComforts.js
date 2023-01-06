document.addEventListener("DOMContentLoaded", function () {
    let comforts = document.getElementsByName("comfort-option");

    for (let comfort of comforts) {
        comfort.addEventListener("click", function () {
            addComfort(comfort.value);
        })
    }
});

function addComfort(comfortValue) {
    let fieldId = getIdOfComfortsField(comfortValue);
    let comfort = getComfort(comfortValue);

    document.getElementById(fieldId).value += comfort + " ";
}

function getIdOfComfortsField(comfortValue) {
    let finishAt = comfortValue.lastIndexOf("-");
    let id = comfortValue.substring(0, finishAt);

    return id;
}


function getComfort(comfortValue) {
    let startAt = comfortValue.lastIndexOf("-") + 1;
    let comfort = comfortValue.substring(startAt);

    return comfort;
}