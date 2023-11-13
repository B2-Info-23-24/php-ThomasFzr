// === Slider prix ===

let minValue = document.getElementById("min-value");
let maxValue = document.getElementById("max-value");

const rangeFill = document.querySelector(".range-fill");

function validateRange() {
  let minPrice = parseInt(inputSliderElements[0].value);
  let maxPrice = parseInt(inputSliderElements[1].value);

  if (minPrice > maxPrice) {
    let tempValue = maxPrice;
    maxPrice = minPrice;
    minPrice = tempValue;
  }

  const minPercentage = ((minPrice - 10) / 490) * 100;
  const maxPercentage = ((maxPrice - 10) / 490) * 100;

  rangeFill.style.left = minPercentage + "%";
  rangeFill.style.width = maxPercentage - minPercentage + "%";

  minValue.innerHTML = minPrice + " €";
  maxValue.innerHTML = maxPrice + " €";
}

const inputSliderElements = document.getElementsByClassName("input-slider");

Array.from(inputSliderElements).forEach(function(element) {
  element.addEventListener("input", validateRange);
});

validateRange();


// === DATE ===

const today = new Date().toISOString().split('T')[0];

const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
const formattedDateTomorrow = tomorrow.toISOString().split('T')[0];

document.getElementById("dateDebut").value = today;
document.getElementById("dateDebut").attributes.getNamedItem("min").value = today;

const newMinForDateFin = document.createAttributeNS(null, "min");
newMinForDateFin.value = formattedDateTomorrow;
document.getElementById("dateFin").setAttributeNode(newMinForDateFin);
document.getElementById("dateFin").value = formattedDateTomorrow;

function updateDateFinMin() {
  const dateDebutValue = document.getElementById("dateDebut").value;
  const dateFin = new Date(dateDebutValue);
  dateFin.setDate(dateFin.getDate() + 1);
  const formatteddateFin = dateFin.toISOString().split('T')[0];

  document.getElementById("dateFin").attributes.getNamedItem("min").value = formatteddateFin;
  document.getElementById("dateFin").value = formatteddateFin;
}
