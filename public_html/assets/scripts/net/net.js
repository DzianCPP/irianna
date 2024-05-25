document.addEventListener(
    "DOMContentLoaded",
    function () {
        document
            .getElementById("hotels-btn")
            .addEventListener(
                "click",
                function () {
                    let url = buildUrl();
                    window.location = url;
                }
            )
    }
);

function buildUrl() {
    return "/net?hotel="
        + document
            .getElementById("hotels")
            .value
        ;
}