document.body.addEventListener("click", function () {
    let all_button = document.getElementsByTagName('button');
    for (var btn of all_button) {
        if (btn.innerHTML == '-') {
            btn.addEventListener("click", function (event) {
                removeForm(event);
            });
        }
    }
});

window.addEventListener("load", function () {
    let all_button = document.getElementsByTagName('button');
    for (var btn of all_button) {
        if (btn.innerHTML == '-') {
            btn.addEventListener("click", function (event) {
                removeForm(event);
            });
        }
    }
});

function removeForm(event) {
    let clicked_btn = event.srcElement;
    let btn_div = clicked_btn.parentElement;
    let container = btn_div.parentElement;
    container.remove();
}