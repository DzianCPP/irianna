window.addEventListener("load", function () {
    var sorted_options = [];
    var non_sorted = [];
    document.querySelectorAll('#search-to-minsk-date > option').forEach((option) => {
        non_sorted.push(option.value);
    });
    sorted_options = non_sorted.sort(function (a, b) {
        var aa = a.split('.').reverse().join(),
            bb = b.split('.').reverse().join();
        return aa < bb ? -1 : (aa > bb ? 1 : 0);
    });
    var unique = [];

    for (var opt of sorted_options) {
        if (unique.includes(opt)) {
            continue;
        } else {
            unique.push(opt);
        }
    }

    console.log(unique);

    for (var i = document.getElementById("search-to-minsk-date").length; i >= 0; i--) {
        this.document.getElementById("search-to-minsk-date").remove(i);
    }

    var zero_option = document.createElement('option');
    zero_option.setAttribute('value', unique[0]);
    zero_option.innerHTML = 'Выбрать';
    document.getElementById("search-to-minsk-date").appendChild(zero_option);

    for (var u of unique) {
        if (u == 0) {
            continue;
        }
        var new_option = document.createElement('option');
        new_option.setAttribute('value', u);
        new_option.innerHTML = u;
        document.getElementById("search-to-minsk-date").appendChild(new_option);
    }
});