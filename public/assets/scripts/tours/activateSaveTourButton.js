document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("manager").addEventListener("click", function () {
        activateSaveTourButton();
    });

    document.getElementById("manager").addEventListener("click", function () {
        activateSaveTourButton();
    });

    document.getElementById("country").addEventListener("click", function () {
        activateSaveTourButton();
    });

    document.getElementById("resort").addEventListener("click", function () {
        activateSaveTourButton();
    });

    document.getElementById("hotels").addEventListener("click", function () {
        activateSaveTourButton();
    });

    document.getElementById("rooms").addEventListener("click", function () {
        activateSaveTourButton();
    });
    
    document.getElementById("departure-from-minsk").addEventListener("click", function () {
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
    
    return true;
}