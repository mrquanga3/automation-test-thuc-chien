/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
function swapInput() {
  disableButton("#input-example button");
  clearMessage();
  showDelay("#input-example button");
  pauseThenToggleControls("input");
}

function swapCheckbox() {
  disableButton("#checkbox-example button");
  clearMessage();
  showDelay("#checkbox-example button");
  pauseThenToggleControls("checkbox");
}

function disableButton(locator) {
  $(locator).attr("disabled", true);
}

function clearMessage() {
  if ($("#message").length) {
    $("#message").first().remove();
  }
}

function showDelay(locator) {
  $(locator).after(
    "<div id='loading'>Wait for it... <img src='/img/ajax-loader.gif'></div></br>"
  );
}

function pauseThenToggleControls(target) {
  setTimeout(function () {
    if (target === "checkbox") {
      toggleCheckboxControls();
    } else if (target === "input") {
      toggleInputControls();
    }
  }, 3000);
}

function toggleCheckboxControls() {
  const btn = $("#checkbox-example button").first();
  const check = $("#checkbox").first();
  const load = $("#loading");
  if (btn.text() == "Remove") {
    check.remove();
    btn.text("Add");
    btn.after("<p id='message'>It's gone!</p>");
    btn.attr("disabled", false);
    load.hide();
  } else {
    btn.text("Remove");
    btn.after("<div><input type='checkbox' id='checkbox'> A checkbox</div>");
    btn.after("<p id='message'>It's back!</p>");
    btn.attr("disabled", false);
    load.hide();
  }
}

function toggleInputControls() {
  const btn = $("#input-example button").first();
  const input = $("#input-example input").first();
  const load = $("#loading");
  if (btn.text() == "Enable") {
    input.prop("disabled", false);
    btn.after("<p id='message'>It's enabled!</p>");
    btn.text("Disable");
    btn.attr("disabled", false);
    load.hide();
  } else {
    btn.text("Enable");
    input.prop("disabled", true);
    btn.after("<p id='message'>It's disabled!</p>");
    btn.attr("disabled", false);
    load.hide();
  }
}
