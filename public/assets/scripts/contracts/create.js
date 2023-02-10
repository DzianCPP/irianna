document.addEventListener("DOMContentLoaded", function () {
    const button = document.querySelector('#save-btn');
    button.addEventListener('click', async function () {
        let content = tinymce.activeEditor.getContent();
        console.log(content);
        let url = "/contracts/create";
        let document_html = content;
        let type_of_document = document.getElementById("type-of-document");
        let info = {
            label: type_of_document,
            html: document_html
        };

        let POST = {
            method: 'POST',
            body: JSON.stringify(info)
        };

        let respose = await fetch(url, POST);

        if (!respose.ok) {
            alert("Ошибка");
        } else {
            console.log("Документ сохранен");
            window.location = "/";
        }
    });
});