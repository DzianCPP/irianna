document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("delete-btn").addEventListener("click", _delete);
})

async function _delete() {
    if (!confirm("Вы действительно хотите удалить выбранные курорты?")) {
        return;
    }

    let checkboxes = document.getElementsByName("select");
    let ids = getIds(checkboxes);
    let url = "/resorts/delete";
    let deleteRequest = {
        method: "DELETE",
        body: JSON.stringify(ids)
    };

    let response = await fetch(url, deleteRequest);

    if (response.ok != false) {
        location.reload();
    } else {
        alert("Что-то пошло не так");
    }
}

function getIds(checkboxes) {
    let ids = new Array();
    let i = 0;

    for (let checkbox in checkboxes) {
        ids[i] = checkbox.value;
        i++;
    }

    return ids;
}