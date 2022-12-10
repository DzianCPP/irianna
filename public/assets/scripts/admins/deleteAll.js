let deleteAllBtn = document.getElementById("delete-all");
deleteAllBtn.addEventListener("click", deleteAll);

function deleteAll() {
    let allCheckboxes = document.getElementsByName("select-user");
    let checkedAdminsIds = getCheckedUsers(allCheckboxes);

    if (confirm("Вы уверены в этом?")) {
        let url = "/admins/delete";

        let users = {};

        for (var i = 0; i < checkedUsersIds.length; i++) {
            var key = "admin" + i;
            Object.defineProperty(users, key, {
                value: checkedAdminsIds[i],
                enumerable: true
            });
        }

        let deleteRequest = {
            method: "DELETE",
            body: JSON.stringify(users)
        };

        fetch(url, deleteRequest)
            .then(() => {
                location.reload(true);
            });
    }
}

function getCheckedUsers(allCheckboxes) {
    let checkedAdminsIds = new Array();

    for (var i = 0; i < allCheckboxes.length; i++) {
        if (allCheckboxes[i].checked === true) {
            checkedAdminsIds.push(allCheckboxes[i].value);
        }
    }

    return checkedAdminsIds;
}