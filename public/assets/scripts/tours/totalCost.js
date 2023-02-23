document.addEventListener("DOMContentLoaded", function () {
    let service_costs = document.getElementsByName("sub-service-cost");
    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let service_costs_values = 0;

        for (let sc of service_costs) {
            service_costs_values += Number(sc.value);
        }

        service_costs_values += Number(document.getElementById("main-client-service-cost").value);

        document.getElementById("total-service-cost").innerHTML = service_costs_values;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let tour_costs = document.getElementsByName("sub-tour-cost");

    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let tour_costs_values = 0;

        for (let tc of tour_costs) {
            tour_costs_values += Number(tc.value);
        }

        tour_costs_values += Number(document.getElementById("main-client-tour-cost").value);

        document.getElementById("total-tour-cost").innerHTML = tour_costs_values;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("load", function () {
        document.getElementById("total-currency").innerHTML = document.getElementById("main-client-currency").value;
    });
});

document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("load", function () {
        document.getElementById("total-currency-1").innerHTML = document.getElementById("main-client-currency-1").value;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let tour_costs_currency = document.getElementsByName("sub-tour-cost-currency");

    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let tour_costs_currency_values = 0;

        for (let tc of tour_costs_currency) {
            tour_costs_currency_values += Number(tc.value);
        }

        tour_costs_currency_values += Number(document.getElementById("main-client-total-cost-currency").value);

        if (tour_costs_currency_values != 0) {
            document.getElementById("total-cost-currency").innerHTML = tour_costs_currency_values;
        } else {
            document.getElementById("total-cost-currency").innerHTML = "-";
        }
    });
});