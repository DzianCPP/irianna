document.addEventListener("DOMContentLoaded", function () {
    let add_subclient_btn = document.getElementsByName("add-subclient");

    for (var btn of add_subclient_btn) {
        btn.addEventListener("click", function () {
            addForm();
        });
    }
});

function addForm() {
    const cont = createContainer();
    const row = createRow();
    const _cols = setCols("col-xs-12 col-sm-12 col-md-12 col-xl-12");
    _cols.appendChild(createNameInputGroup());
    _cols.appendChild(createPassportInputGroup());
    _cols.appendChild(createBirthDateInputGroup());
    _cols.appendChild(createServiceCost());
    _cols.appendChild(createTourCost());
    _cols.appendChild(createTourCostCurrency())
    row.appendChild(_cols);
    cont.appendChild(row);
    document.getElementById("clients").appendChild(cont);
}

function createContainer() {
    const _container = document.createElement('div');
    _container.setAttribute("class", "container-fluid w-100 border border-dark border-1 border-start-0 border-end-0 border-bottom-0 rounded-0 pt-2");
    _container.setAttribute("name", "sub-client");

    return _container;
}

function createRow() {
    const _row = document.createElement('div');
    _row.setAttribute("class", "row w-100 mb-2");

    return _row;
}

function setCols(className) {
    const _cols = document.createElement('div');
    _cols.setAttribute("class", className);

    return _cols;
}

function createNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group");
    _input_group.appendChild(createSpan("input-group-text w-25", "ФИО"));
    _input_group.appendChild(createInputText("form-control", "text", "sub-client-name", "Введите ФИО клиента"));
    return _input_group;
}

function createPassportInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-25", "Паспорт"));
    _input_group.appendChild(createInputText("form-control", "text", "sub-client-passport", "Введите серию и номер паспорта"));

    return _input_group;
}

function createBirthDateInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-50", "Дата рождения"));
    _input_group.appendChild(createInputText("form-control", "date", "sub-client-birth-date", ""));

    return _input_group;
}

function createSpan(className, innerText) {
    const _span = document.createElement("span");
    _span.setAttribute("class", className);
    _span.innerText = innerText;

    return _span;
}

function createInputText(className, typeName, nameName, placeholder) {
    const _input_text = document.createElement("input");
    _input_text.setAttribute("class", className);
    _input_text.setAttribute("type", typeName);
    _input_text.setAttribute("name", nameName)
    _input_text.setAttribute("placeholder", placeholder);

    return _input_text;
}

function createServiceCost() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-50 bg-primary text-light", "Тур. услуга"));
    _input_group.appendChild(createInputText("form-control", "text", "service-cost", "Стоимость услуги в BYN"));

    return _input_group;
}

function createTourCost() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-50 bg-primary text-light", "Стоимость тура"));
    _input_group.appendChild(createInputText("form-control", "text", "tour-cost", ""));
    _input_group.appendChild(createSpan("input-group-text", document.getElementById("main-client-currency-1").value));

    return _input_group;
}

function createTourCostCurrency() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-50 bg-primary text-light", "Стоимость тура"));
    _input_group.appendChild(createInputText("form-control", "text", "tour-cost-currency", ""));
    _input_group.appendChild(createSpan("input-group-text", document.getElementById("main-client-currency").value));
    return _input_group;
}
