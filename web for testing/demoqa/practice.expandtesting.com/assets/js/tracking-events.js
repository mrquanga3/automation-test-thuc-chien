/* eslint-disable no-undef */

// Track page view event
//=======================
gtag("event", "page_view", {
  event_category: "Page Tracking",
  event_label: "Example Page"
});
showSuccessFlashMessage("page_view");

// Click Event Tracking
//=======================
$("#click-event-btn").on("click", function () {
  gtag("event", "click", {
    event_category: "button",
    event_label: "example-button"
  });

  showSuccessFlashMessage("click");
});

$("#click-event-link").on("click", function () {
  gtag("event", "click", {
    event_category: "link",
    event_label: "example-link"
  });
  showSuccessFlashMessage("click");
});

// Submit Event Tracking
//=======================
$("#submit-event-form").on("submit", function (event) {
  event.preventDefault();
  gtag("event", "submit", { event_category: "form", event_label: "example-form" });
  showSuccessFlashMessage("submit");
});

// Conversion Event Tracking
//=======================
$("#conversion-event-btn").on("click", function () {
  gtag("event", "conversion", { send_to: "AW-123456789/abc123", value: 10.0, currency: "EUR" });
  showSuccessFlashMessage("conversion");
});

// Track scroll event when user reaches 50% of div
//================================================
let scrollTriggered = false;
const scrollPercent = 50;
const scrollContainer = document.getElementById("scrollable-div");
const scrollPosition = Math.round(
  (scrollContainer.scrollTop / (scrollContainer.scrollHeight - scrollContainer.clientHeight)) * 100
);
if (scrollPosition >= scrollPercent) {
  gtag("event", "scroll", {
    event_category: "Scroll Tracking",
    event_label: "User reached " + scrollPercent + "% of page"
  });
  scrollTriggered = true;
}

// Listen for scroll event
scrollContainer.addEventListener("scroll", function () {
  const scrollPosition = Math.round(
    (scrollContainer.scrollTop / (scrollContainer.scrollHeight - scrollContainer.clientHeight)) *
      100
  );
  if (scrollPosition >= scrollPercent && !scrollTriggered) {
    gtag("event", "scroll", {
      event_category: "Scroll Tracking",
      event_label: "User reached " + scrollPercent + "% of page"
    });
    scrollTriggered = true;

    showSuccessFlashMessage("scroll");
  }
});

function showSuccessFlashMessage(eventName) {
  const htmlMessage = `
    <div class="row">
    <div id="flash-message">
        <div id="flash" class="alert alert-success alert-dismissible fade show" role="alert">
            <b>The ${eventName} tracking event was triggered successfully!</b>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    </div>`;

  $("#flash-message").html(htmlMessage);
  $("#flash-message")[0].scrollIntoView();
}
