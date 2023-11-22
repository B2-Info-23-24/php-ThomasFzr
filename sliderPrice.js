// === Slider prix ===

document.addEventListener('DOMContentLoaded', function() {
  let minValue = document.getElementById("min-value");
  let maxValue = document.getElementById("max-value");

  const rangeFill = document.querySelector(".range-fill");

  function validateRange() {
      let minPrice = parseInt(document.querySelector(".input-slider.min-price").value);
      let maxPrice = parseInt(document.querySelector(".input-slider.max-price").value);

      const minPercentage = (minPrice / 500) * 100;
      const maxPercentage = (maxPrice / 500) * 100;

      rangeFill.style.left = minPercentage + "%";
      rangeFill.style.width = maxPercentage - minPercentage + "%";

      minValue.innerHTML = (minPrice * 2) + " €";
      maxValue.innerHTML = (maxPrice * 2) + " €";
  }

  const inputSliderElements = document.querySelectorAll(".input-slider");

  inputSliderElements.forEach(function(element) {
      element.addEventListener("input", validateRange);
  });

  validateRange();
});

