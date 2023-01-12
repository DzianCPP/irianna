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
    const emptyCols = setCols("col-xs-12 col-sm-12 col-md-4 col-xl-4");
    const _cols = setCols("col-xs-12 col-sm-12 col-md-4 col-xl-4");
    _cols.appendChild(createLastNameInputGroup());
    _cols.appendChild(createFirstNameInputGroup());
    _cols.appendChild(createSecondNameInputGroup());
    _cols.appendChild(createPassportInputGroup());
    _cols.appendChild(createBirthDateInputGroup());
    row.appendChild(emptyCols);
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

function createLastNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group");
    _input_group.appendChild(createSpan("input-group-text w-25", "Фамилия"));
    _input_group.appendChild(createInputText("form-control", "text", "sub-client-last-name", "Введите фамилию клиента"));
    return _input_group;
}

function createFirstNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-25", "Имя"));
    _input_group.appendChild(createInputText("form-control", "text", "sub-client-first-name", "Введите имя клиента"));

    return _input_group;
}

function createSecondNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-25", "Отчество"));
    _input_group.appendChild(createInputText("form-control", "text", "sub-client-second-name", "Введите отчество клиента"));

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
