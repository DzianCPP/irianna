document.getElementById("save-btn")
    .addEventListener("click", () => { save() });

async function save() {
    let url = "/stamps/create";

    let post_request = {
        method: "POST",
        body: getFormData()
    };

    let response = await fetch(url, post_request);
    if (response.ok != true) {
        console.log('Error saving a stamp file');
        console.log(await response.json());
        let error_field = document.getElementById("error-field");
        error_field.innerHTML = "Не удалось сохранить печать";

        return;
    }

    window.location = "/stamps";
}

let getFormData = function () {
    let manager_id = document.getElementById("manager").value;
    let stamp_file = document.getElementById("stamp-file").files[0];
    let form_data = new FormData();

    form_data.append("stamp", stamp_file);
    form_data.append("manager_id", manager_id);

    return form_data;
}