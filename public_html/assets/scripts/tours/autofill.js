document.addEventListener("click", () => { addListenerToNameFields(); });

function addListenerToNameFields() {
    for (let _name of document.getElementsByName("name")) {
        let name = _name;
        name.addEventListener("keyup", function () {
            autofill(name);
        });
    }

    for (let _subname of document.getElementsByName("sub-client-name")) {
        let subname = _subname;
        subname.addEventListener("keyup", function () {
            autofill(subname);
        });
    }
}

function autofill(eventCaller) {
    if (eventCaller.value.length < 3) {
        return;
    }

    let jsonClientInfo = getClientInfo(eventCaller.value);
}

async function getClientInfo(searchInfo) {
    let url = "/clients_autofill";
    let params = {};
    if (searchInfo) {
        Object.defineProperty(
            params,
            'name',
            {
                value: searchInfo,
                enumerable: true
            }
        );
    }

    let POST = {
        method: 'POST',
        body: JSON.stringify(params)
    };

    let response = await fetch (url, POST);

    if (!response.ok) {
        console.log("Ошибка: не удалось автозаполнить данные туриста");
        return;
    }

    let jsonInfo = await response.json();

    return jsonInfo;
}