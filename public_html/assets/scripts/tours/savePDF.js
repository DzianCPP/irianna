document
    .getElementById('save-pdf')
    .addEventListener('click', function () {
        savePDF();
    });

async function savePDF() {
    pdfMake
        .createPdf({
            content: htmlToPdfmake(await getContractHTML())
        })
        .download();
}

async function getContractHTML() {
    let url = "/contract-html";
    let request = {
        method: 'GET'
    };

    let response = await fetch(url, request);

    if (!response.ok) {
        alert('Не удалось получить PDF файл договора');

        return;
    }

    return response.text();
}