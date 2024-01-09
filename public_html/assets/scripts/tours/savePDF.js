document
    .getElementById('save-pdf')
    .addEventListener('click', function () {
        savePDF();
    });

async function savePDF() {
    var docDefinition = {
        content: [
            {
                text: await getContractHTML()
            }
        ],
        defaultStyle: {}
    };
    pdfMake.createPdf(docDefinition).download();
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

    return await response.body;
}