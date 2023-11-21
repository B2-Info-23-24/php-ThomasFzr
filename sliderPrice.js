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