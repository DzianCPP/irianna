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

async function autofill(eventCaller) {
    if (eventCaller.value.length < 3) {
        return;
    }

    let jsonClientInfo = await getClientInfo(eventCaller.value);

    if (
        jsonClientInfo === undefined
        || !jsonClientInfo
        || jsonClientInfo.length < 1
        || jsonClientInfo['status'] != 200
    ) {
        return;
    }

    jsonClientInfo = jsonClientInfo[0];

    createAutofillProposal(eventCaller, jsonClientInfo);
}

function createAutofillProposal(eventCaller, clientInfo) {
    let eventCallerParent = eventCaller.parentNode;
    let proposal = addAutofillProposal(eventCallerParent, clientInfo);

    proposal.addEventListener('click', function () {
        fillForm(eventCaller, clientInfo);
    });
}

function fillForm(eventCaller, clientInfo) {
    eventCaller.value = clientInfo[1];
    let inputGroup = eventCaller.parentNode;
    let formRow = inputGroup.parentNode;
    for (let child of formRow.children) {
        for (let innerChild of child.children) {
            if (innerChild.nodeName == 'INPUT') {
                if (
                    innerChild
                        .id
                        .includes('passport')
                    || innerChild
                        .getAttribute('name')
                        .includes('passport')
                ) {
                    innerChild.value = clientInfo[4];
                }

                if (innerChild.id.includes('phone-main')) {
                    innerChild.value = clientInfo[2];
                }

                if (innerChild.id.includes('phone-sec')) {
                    innerChild.value = clientInfo[3];
                }

                if (innerChild.id.includes('address')) {
                    innerChild.value = clientInfo[6];
                }

                if (
                    innerChild
                        .id
                        .includes('birth')
                    || innerChild
                        .getAttribute('name')
                        .includes('birth')
                ) {
                    innerChild.value = clientInfo[5];
                }
            }
        }
    }
}

function addAutofillProposal(divEl, clientInfo) {
    for (let oldProposal of document.getElementsByName(divEl.id + '-proposal')) {
        oldProposal.remove();
    }

    const proposal = document.createElement('button');
    proposal.setAttribute('value', clientInfo[1]);
    proposal.setAttribute('name', divEl.id + '-proposal');
    proposal.innerHTML = clientInfo[1];
    proposal.setAttribute('class', 'btn btn-warning');
    divEl.appendChild(proposal);

    return proposal;
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

    let response = await fetch(url, POST);

    if (!response.ok) {
        console.log("Ошибка: не удалось автозаполнить данные туриста");
        return;
    }

    let jsonInfo = await response.json();

    return jsonInfo;
}