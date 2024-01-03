document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('archived-clients').addEventListener('change', function () {
        getArchivedClients();
    });
});

function getArchivedClients() {
    let archived_checkbox_value = document
        .getElementById('archived-clients')
        .checked;

    window.location = "clients?archived=" + archived_checkbox_value;
}