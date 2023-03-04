// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("bus-from").addEventListener("click", function () {
//         addDepartureFromResort();
//     });
// });

// async function addDepartureFromResort() {
//     let url = "/roomsOne/" + document.getElementById("rooms").value;
//     let GET = {
//         method: "GET"
//     };
//     let room = await fetch(url, GET);
//     if (!room.ok) {
//         alert("Ошибка сервера");
//     } else {
//         let room_info = await room.json();
//         let from_resort = room_info.checkin_checkout_dates;
//         console.log(from_resort);
//         addOptions(from_resort);
//     }
// }

// function addOptions(from_resort) {
//     let toMinskSelector = document.getElementById("departure-from-resort");
//     let dates = from_resort.trim().split(", ");

//     for (let i = 0; i < dates.length; i++) {
//         dates[i] = dates[i].substring(1);
//     }

//     console.log(dates);

//     for (let i = toMinskSelector.length - 1; i >= 0; i--) {
//         toMinskSelector.remove(i);
//     }

//     for (let k = dates.length/2; k < dates.length; k++) {
//         var newOption = document.createElement('option');
//         var optionText = document.createTextNode(dates[k]);
//         newOption.appendChild(optionText);
//         newOption.setAttribute('value', dates[k]);
//         toMinskSelector.appendChild(newOption);
//     }
// }