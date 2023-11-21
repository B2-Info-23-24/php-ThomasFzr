// === DATE ===

const today = new Date().toISOString().split('T')[0];

const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
const formattedDateTomorrow = tomorrow.toISOString().split('T')[0];

const dateDebutInput = document.getElementById("dateDebut");
const dateFinInput = document.getElementById("dateFin");
const differenceInDaysElement = document.getElementById("differenceInDays");

dateDebutInput.value = today;
dateDebutInput.min = today;

dateFinInput.value = formattedDateTomorrow;
dateFinInput.min = formattedDateTomorrow;

function updateDateFinMin() {
  const dateDebutValue = dateDebutInput.value;
  let dateFinValue = dateFinInput.value;

  const minDateFin = new Date(dateDebutValue);
  minDateFin.setDate(minDateFin.getDate() + 1);
  if (new Date(dateFinValue) < minDateFin) {
    dateFinValue = minDateFin.toISOString().split('T')[0];
  }

  dateFinInput.min = dateDebutValue;
  dateFinInput.value = dateFinValue;

  const diffInDays = calculateDateDifferenceInDays(dateDebutValue, dateFinValue);
  differenceInDaysElement.textContent = diffInDays;
}


dateDebutInput.addEventListener("input", updateDateFinMin); 
dateFinInput.addEventListener("input", updateDateFinMin);

function calculateDateDifferenceInDays(startDate, endDate) {
  const start = new Date(startDate);
  const end = new Date(endDate);
  const timeDifference = end.getTime() - start.getTime();
  const diffInDays = timeDifference / (1000 * 3600 * 24);
  return Math.floor(diffInDays);
}

