/* eslint-disable no-undef */

function showErrorResponse(xhr) {
  let errorMessage = "An error occurred while processing your request.";
  switch (xhr.status) {
    case 400:
      errorMessage = xhr.responseText || errorMessage;
      break;
    default:
  }

  const htmTemplate = `
        <div class="alert alert-danger">
            <p><b id="resultMessage">${errorMessage}</b></p>
        </div>`;

  $("#result").html(htmTemplate);
  $("#result").show();
}

function showSuccessResponse(result) {
  let costMessage = `${result.days} Day(s), ${result.hours} Hour(s), ${result.minutes} Minute(s)`;
  if (result.years) {
    costMessage = `${result.years} Year(s), ${costMessage}`;
  }

  const htmTemplate = `
        <div class="alert alert-info">
            <p><b id="resultValue">${result.cost.toFixed(2)}€</b></p>
            <p><b id="resultMessage">${costMessage}</b></p>
        </div>`;

  $("#result").html(htmTemplate);
  $("#result").show();
}

function toggleReservationDetails(isEnabled) {
  $("#calculateCost").prop("disabled", !isEnabled);
  $("#parkingLot").prop("disabled", !isEnabled);
  $("#entryDate").prop("disabled", !isEnabled);
  $("#exitDate").prop("disabled", !isEnabled);
  $("#entryTime").prop("disabled", !isEnabled);
  $("#exitTime").prop("disabled", !isEnabled);
}

function getReservationDetails() {
  const entryDate = $("#entryDate").val();
  const exitDate = $("#exitDate").val();
  const entryTime = $("#entryTime").val();
  const exitTime = $("#exitTime").val();
  const parkingLot = $("#parkingLot").val();

  const entryDateTime = entryDate + "T" + entryTime;
  const exitDateTime = exitDate + "T" + exitTime;

  const parkingData = {
    parkType: parkingLot,
    entryDate: entryDateTime,
    exitDate: exitDateTime
  };

  return parkingData;
}

function initializePage() {
  const entryDateConfig = {
    enableTime: false,
    dateFormat: "Y-m-d",
    allowInput: true,
    defaultDate: new Date(),
    minDate: "today",
    disableMobile: true
  };

  const entryTimeConfig = {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    allowInput: true,
    defaultDate: new Date(),
    disableMobile: true
  };

  $("#entryDate").flatpickr(entryDateConfig);
  $("#entryTime").flatpickr(entryTimeConfig);

  const exitDate = new Date();
  exitDate.setDate(exitDate.getDate() + 1);

  const exitDateConfig = {
    enableTime: false,
    dateFormat: "Y-m-d",
    allowInput: true,
    defaultDate: exitDate,
    minDate: "today",
    disableMobile: true
  };

  const exitTimeConfig = {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    allowInput: true,
    defaultDate: new Date(),
    disableMobile: true
  };

  $("#exitDate").flatpickr(exitDateConfig);
  $("#exitTime").flatpickr(exitTimeConfig);
}

$(document).ready(function () {
  const ENABLE_RESERVATION_ELEMENTS = true;
  const DISABLE_RESERVATION_ELEMENTS = false;

  let requestInProgress = false;
  initializePage();

  const elements = $("#parkingLot, #entryDate, #entryTime, #exitDate, #exitTime");

  elements.on("change", function () {
    const id = $(this).attr("id");
    if (requestInProgress === false) {
      console.log(`id=${id}: On change detected!`);
      $("#result").html("");
      $("#result").hide();
      $("#reserveOnline").remove();
    }
  });

  $("#calculateCost").click(function () {
    toggleReservationDetails(DISABLE_RESERVATION_ELEMENTS);

    $("#result").html("");
    const reserveOnlineButton = $("#reserveOnline");

    if (reserveOnlineButton.length > 0) {
      reserveOnlineButton.remove();
    }

    requestInProgress = true;
    const parkingData = getReservationDetails();

    $.ajax({
      type: "POST",
      url: "/webpark/calculate-cost",
      data: parkingData,
      success: function (result) {
        console.log(result);
        showSuccessResponse(result);

        const reserveOnlineButton = $("#reserveOnline");

        if (reserveOnlineButton.length === 0) {
          $("#actions").append(
            `<a href="/webpark/booking/${result.reservation_id}" data-testid= "reserve-online" class="btn btn-expand mt-3 mx-2" id="reserveOnline">Book Now!</a>`
          );
        }
      },
      error: function (xhr) {
        showErrorResponse(xhr);
      },
      complete: function () {
        toggleReservationDetails(ENABLE_RESERVATION_ELEMENTS);
        // set
        setTimeout(() => {
          requestInProgress = false;
        }, 800);
      }
    });
  });
});
