document.addEventListener("DOMContentLoaded", function () {
    let service_costs = document.getElementsByName("service-cost");
    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let service_costs_values = 0;

        for (let sc of service_costs) {
            service_costs_values += Number(sc.value);
        }

        document.getElementById("total-service-cost").innerHTML = service_costs_values;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let tour_costs = document.getElementsByName("tour-cost");

    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let tour_costs_values = 0;

        for (let tc of tour_costs) {
            tour_costs_values += Number(tc.value);
        }

        document.getElementById("total-tour-cost").innerHTML = tour_costs_values;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("main-client-currency").addEventListener("keyup", function () {
        document.getElementById("total-currency").innerHTML = document.getElementById("main-client-currency").value;
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("main-client-currency-1").addEventListener("keyup", function () {
        document.getElementById("total-currency-1").innerHTML = document.getElementById("main-client-currency-1").value;
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let tour_costs_currency = document.getElementsByName("tour-cost-currency");

    document.getElementById("calculate-total-cost").addEventListener("click", function () {
        let tour_costs_currency_values = 0;

        for (let tc of tour_costs_currency) {
            tour_costs_currency_values += Number(tc.value);
        }

        if (tour_costs_currency_values != 0) {
            document.getElementById("total-cost-currency").innerHTML = tour_costs_currency_values;
        } else {
            document.getElementById("total-cost-currency").innerHTML = "-";
        }
    });
});