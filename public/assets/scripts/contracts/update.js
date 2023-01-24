document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("save-btn").addEventListener("click", update);
});

async function update() {
    let url = "/contracts/update";
    let _html = document.getElementById("summernote").innerHTML;
    let _name = document.getElementById("document-name").innerHTML;
    let _label = document.getElementById("document-label").innerHTML;
    let _id = document.getElementById("document-id").innerHTML;
    let info = {
        name: _name,
        label: _label,
        html: _html,
        id: _id
    };

    let PUT = {
        method: 'PUT',
        body: JSON.stringify(info)
    };

    let response = await fetch(url, PUT);

    if (await response.ok != false) {
        console.log("Document updated");
        window.location = "/contracts";
    } else {
        console.log("Документ не обновился");
        document.getElementById("error-field").innerHTML = "Не удалось обновить документ. Попробуйте внести изменения в другой программе (Google DOCS, MS Word) и сохранить документ как новый";
    }
}