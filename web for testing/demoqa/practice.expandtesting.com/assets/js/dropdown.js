/* eslint-disable no-undef */
// eslint-disable-next-line no-undef
$(document).ready(function () {
  const dropdown = document.getElementById("dropdown");
  dropdown.onchange = function (event) {
    const options = dropdown.getElementsByTagName("option");
    for (let i = 0; i < options.length; i++) {
      options[i].removeAttribute("selected");
    }
    document
      .querySelector(`#dropdown option[value='${event.target.value}']`)
      .setAttribute("selected", "selected");
  };

  const dropdownCountry = document.getElementById("country");
  dropdownCountry.onchange = function (event) {
    const options = dropdownCountry.getElementsByTagName("option");
    for (let i = 0; i < options.length; i++) {
      options[i].removeAttribute("selected");
    }
    document
      .querySelector(`#country option[value='${event.target.value}']`)
      .setAttribute("selected", "selected");
  };

  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
  ];
  const qntYears = 100;
  const selectYear = $("#year");
  const selectMonth = $("#month");
  const selectDay = $("#day");
  let currentYear = new Date().getFullYear();

  for (let y = 0; y < qntYears; y++) {
    const yearElem = document.createElement("option");
    yearElem.value = currentYear;
    yearElem.textContent = currentYear;
    selectYear.append(yearElem);
    currentYear--;
  }

  for (let m = 0; m < 12; m++) {
    const monthNum = new Date(2018, m).getMonth();
    const month = monthNames[monthNum];
    const monthElem = document.createElement("option");
    monthElem.value = monthNum;
    monthElem.textContent = month;
    selectMonth.append(monthElem);
  }

  const d = new Date();
  const month = d.getMonth();
  const year = d.getFullYear();
  const day = d.getDate();

  selectYear.val(year);
  selectYear.on("change", AdjustDays);
  selectMonth.val(month);
  selectMonth.on("change", AdjustDays);

  AdjustDays();
  selectDay.val(day);

  function AdjustDays() {
    const year = selectYear.val();
    const month = parseInt(selectMonth.val()) + 1;
    selectDay.empty();

    //get the last day, so the number of days in that month
    const days = new Date(year, month, 0).getDate();

    //lets create the days of that month
    for (let d = 1; d <= days; d++) {
      const dayElem = document.createElement("option");
      dayElem.value = d;
      dayElem.textContent = d;
      selectDay.append(dayElem);
    }
  }
});
