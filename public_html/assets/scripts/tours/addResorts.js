document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("country").addEventListener("change", function () {
        addResorts();
    });
})

function addResorts() {
    let country = document.getElementById("country").value;
    let resortsSelect = document.getElementById("resort");
    let resorts = JSON.parse(document.getElementById("resorts-array").innerHTML);

    for (let i = 0; i < resortsSelect.length; i++) {
        resortsSelect.removeChild(resortsSelect.options[i]);
    }

    for (let l = resortsSelect.length; l >= 0; l--) {
        resortsSelect.remove(l);
    }

    var newOption = document.createElement('option');
    var optionText = document.createTextNode('');
    newOption.appendChild(optionText);
    newOption.setAttribute('value', 0);
    resortsSelect.appendChild(newOption);

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