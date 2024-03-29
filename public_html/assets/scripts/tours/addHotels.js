document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("resort").addEventListener("click", addHotels);
})

function addHotels() {
    let resort = document.getElementById("resort").value;
    let hotelsSelector = document.getElementById("hotels");
    let hotels = JSON.parse(document.getElementById("hotels-array").innerHTML);

    for (let i = 0; i < hotelsSelector.length; i++) {
        hotelsSelector.removeChild(hotelsSelector.options[i]);
    }

    for (let k = hotelsSelector.length; k >= 0; k--) {
        hotelsSelector.remove(k);
    }

    var newOption = document.createElement('option');
    var optionText = document.createTextNode('');
    newOption.appendChild(optionText);
    newOption.setAttribute('value', 0);
    hotelsSelector.appendChild(newOption);

    for (var hotel of hotels) {
        if (hotel.resort_id == resort) {
            var newOption = document.createElement('option');
            var optionText = document.createTextNode(hotel.name);
            newOption.appendChild(optionText);
            newOption.setAttribute('value', hotel.id);
            hotelsSelector.appendChild(newOption);
        }
    }
}