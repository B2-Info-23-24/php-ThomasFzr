let minValue = document.getElementById("min-value");
let maxValue = document.getElementById("max-value");

const rangeFill = document.querySelector(".range-fill");

// Function to validate range and update the fill color on slider
function validateRange() {
  let minPrice = parseInt(inputElements[0].value);
  let maxPrice = parseInt(inputElements[1].value);

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

const inputElements = document.querySelectorAll("input");

// Add an event listener to each input element
inputElements.forEach((element) => {
  element.addEventListener("input", validateRange);
});

// Initial call to validateRange
validateRange();

//date
// const now = new Date();
// const day = ("0" + now.getDate()).slice(-2);
// const month = ("0" + (now.getMonth() + 1)).slice(-2);
// const today = now.getFullYear() + "-" + (month) + "-" + (day);  
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
