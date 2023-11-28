// === DATE ===

const today = new Date().toISOString().split('T')[0];

const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
const formattedDateTomorrow = tomorrow.toISOString().split('T')[0];

const startDateInput = document.getElementById("startDate");
const endDateInput = document.getElementById("endDate");
const differenceInDaysElement = document.getElementById("differenceInDays");

startDateInput.value = today;
startDateInput.min = today;

endDateInput.value = formattedDateTomorrow;
endDateInput.min = formattedDateTomorrow;

function updateendDateMin() {
  const startDateValue = startDateInput.value;
  let endDateValue = endDateInput.value;

  const minendDate = new Date(startDateValue);
  minendDate.setDate(minendDate.getDate() + 1);
  if (new Date(endDateValue) < minendDate) {
    endDateValue = minendDate.toISOString().split('T')[0];
  }

  endDateInput.min = startDateValue;
  endDateInput.value = endDateValue;

  const diffInDays = calculateDateDifferenceInDays(startDateValue, endDateValue);
  differenceInDaysElement.textContent = diffInDays;
}


startDateInput.addEventListener("input", updateendDateMin); 
endDateInput.addEventListener("input", updateendDateMin);

function calculateDateDifferenceInDays(startDate, endDate) {
  const start = new Date(startDate);
  const end = new Date(endDate);
  const timeDifference = end.getTime() - start.getTime();
  const diffInDays = timeDifference / (1000 * 3600 * 24);
  return Math.floor(diffInDays);
}

