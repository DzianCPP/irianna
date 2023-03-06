document.addEventListener("DOMContentLoaded", function () {
    let text_areas = document.getElementsByTagName('textarea');

    for (let ta of text_areas) {
        ta.addEventListener('input', autoResize, false);
    }
});

function autoResize() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
}