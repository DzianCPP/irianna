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
    const _cols = setCols();
    _cols.appendChild(createLastNameInputGroup());
    _cols.appendChild(createFirstNameInputGroup());
    row.appendChild(_cols);
    cont.appendChild(row);
    document.body.appendChild(cont);
}

function createContainer() {
    const _container = document.createElement('div');
    _container.setAttribute("class", "container-fluid w-100");
    _container.setAttribute("name", "sub-client");

    return _container;
}

function createRow() {
    const _row = document.createElement('div');
    _row.setAttribute("class", "row w-100 mb-2");

    return _row;
}

function setCols() {
    const _cols = document.createElement('div');
    _cols.setAttribute("class", "col-xs-12 col-sm-12 col-md-4 col-xl-4");

    return _cols;
}

function createLastNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group");
    _input_group.appendChild(createSpan("input-group-text w-25", "Фамилия"));
    _input_group.appendChild(createInputText("form-control", "text", "last-name", "Введите фамилию клиента"));

    return _input_group;
}

function createFirstNameInputGroup() {
    const _input_group = document.createElement('div');
    _input_group.setAttribute("class", "input-group mt-2");
    _input_group.appendChild(createSpan("input-group-text w-25", "Имя"));
    _input_group.appendChild(createInputText("form-control", "text", "first-name", "Введите имя клиента"));

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