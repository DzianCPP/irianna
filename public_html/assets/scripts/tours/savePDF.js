document
    .getElementById('save-pdf')
    .addEventListener('click', function () {
        savePDF();
    });

function savePDF() {
    var docDefinition = {
        content: [
            {
                text: document.getElementById('tinyMCE').innerHTML
            }
        ],
        defaultStyle: {}
    };
    pdfMake.createPdf(docDefinition).download();
}