document.addEventListener("DOMContentLoaded", function () {
    this.body.addEventListener("mouseover", function () {
        activateSaveTourButton();
    });
});

function activateSaveTourButton() {
    let save_tour_btn = document.getElementById("save-tour");
    save_tour_btn.disabled= true;

    if (fieldsAreValid()) {
        save_tour_btn.disabled = false;
        return;
    }
}

function fieldsAreValid() {
    let manager = document.getElementById("manager").value;
    let country = document.getElementById("country").value;
    let resort = document.getElementById("resort").value;
    let hotel = document.getElementById("hotels").value;
    let room = document.getElementById("rooms").value;
    let departure_from_minsk = document.getElementById("departure-from-minsk").value;
    let main_client_last_name = document.getElementById("main-client-last-name").value;
    let main_client_first_name = document.getElementById("main-client-first-name").value;
    let main_client_main_phone = document.getElementById("main-client-phone-main").value;

    if (!manager) {
        return false;
    }

    if (!country) {
        return false;
    }

    if (!resort) {
        return false;
    }

    if (!hotel) {
        return false;
    }

    if (!room) {
        return false;
    }

    if (!departure_from_minsk) {
        return false;
    }

    if (main_client_last_name.length < 2) {
        return false;
    }

    if (main_client_first_name.length < 2) {
        return false;
    }

    if (main_client_main_phone.length < 7) {
        return false;
    }

    if (document.getElementById("main-client-passport").value.length < 4) {
        return false;
    }

    if (!document.getElementById("main-client-birth-date").value) {
        return false;
    }

    if (document.getElementById("total-service-cost").innerHTML.length < 1) {
        return false;
    }
    
    return true;
}