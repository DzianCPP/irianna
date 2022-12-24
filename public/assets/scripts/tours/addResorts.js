document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("countries").addEventListener("click", addResorts);
})

function addResorts() {
    let country = document.getElementById("countries").value;
    let resortsSelect = document.getElementById("resorts");
    let resorts = JSON.parse(document.getElementById("resorts-array").innerHTML);

    for (let i = 0; i < resortsSelect.length; i++) {
        resortsSelect.removeChild(resortsSelect.options[i]);
    }

    for (var resort of resorts) {
        if (resort.country_id == country) {
            var newOption = document.createElement('option');
            var optionText = document.createTextNode(resort.name);
            newOption.appendChild(optionText);
            newOption.setAttribute('value', resort.id);
            resortsSelect.appendChild(newOption);
        }
    }
}