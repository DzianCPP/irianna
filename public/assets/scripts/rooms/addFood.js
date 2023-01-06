document.addEventListener("DOMContentLoaded", function () {
    let foods = document.getElementsByName("food-option");

    for (let food of foods) {
        food.addEventListener("click", function () {
            addComfort(food.value);
        })
    }
});

function addComfort(foodValue) {
    let fieldId = getIdOfFoodsField(foodValue);
    let foodOption = getFoodOption(foodValue);

    document.getElementById(fieldId).value += foodOption + " ";
}

function getIdOfFoodsField(foodValue) {
    let finishAt = foodValue.lastIndexOf("-");
    let id = foodValue.substring(0, finishAt);

    return id;
}


function getFoodOption(foodValue) {
    let startAt = foodValue.lastIndexOf("-") + 1;
    let foodOption = foodValue.substring(startAt);

    return foodOption;
}