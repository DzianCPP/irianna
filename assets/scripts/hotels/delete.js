document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("delete-all").addEventListener("click", _delete);
});

async function _delete() {
    if (!confirm("Вы действительно хотите удалить выбранные отели?")) {
        return;
    }

    let checkboxes = document.getElementsByName("select");
    let ids = getIds(checkboxes);
    let url = "/hotels/delete";
    let deleteRequest = {
        method: "DELETE",
        body: JSON.stringify(ids)
    };

    let response = await fetch(url, deleteRequest);

    if (response.ok != false) {
        location.reload(true);
    } else {
        alert("Что-то пошло не так");
    }
}

function getIds(checkboxes) {
    let ids = new Array();
    let i = 0;

    for (var checkbox of checkboxes) {
        if (checkbox.checked) {
            ids.push(checkbox.value);
        }
        i++;
    }

    return ids;
}