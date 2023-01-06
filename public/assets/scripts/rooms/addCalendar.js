document.addEventListener("DOMContentLoaded", function () {
    let dates = document.getElementsByName("date");
    for (let date of dates) {
        date.addEventListener("change", function () {
            let _id = date.id;
            let _fieldId = "field-" + _id;
            let _field = document.getElementById(_fieldId);
            let dateRaw = date.value;
            let dateLocal = formatDateDMY(dateRaw);
            _field.value += dateLocal + ", ";
        });
    }
});

function formatDateDMY(dateRaw) {
    let year = dateRaw.substring(0, 4);
    let day = dateRaw.substring(8);
    let month = dateRaw.substring(5, 7);

    return day + "-" + month + "-" + year;
}