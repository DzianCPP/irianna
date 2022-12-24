let deleteAllBtn = document.getElementById("delete-all");
deleteAllBtn.addEventListener("click", deleteAll);

function deleteAll() {
    let allCheckboxes = document.getElementsByName("select");
    let checkedIds = getChecked(allCheckboxes);

    if (confirm("Вы уверены, что хотите удалить выбранные автобусы?")) {
        let url = "/buses/delete";

        let countries = {};

        for (var i = 0; i < checkedIds.length; i++) {
            var key = "bus" + i;
            Object.defineProperty(countries, key, {
                value: checkedIds[i],
                enumerable: true
            });
        }

        let deleteRequest = {
            method: "DELETE",
            body: JSON.stringify(countries)
        };

        fetch(url, deleteRequest)
            .then(() => {
                location.reload(true);
            });
    }
}

function getChecked(allCheckboxes) {
    let checkedIds = new Array();

    for (var i = 0; i < allCheckboxes.length; i++) {
        if (allCheckboxes[i].checked === true) {
            checkedIds.push(allCheckboxes[i].value);
        }
    }

    return checkedIds;
}