/* eslint-disable no-unused-vars */
function jsAlert() {
  alert("I am a Js Alert");
  log("OK");
}

function jsConfirm() {
  const c = confirm("I am a Js Confirm");
  const result = c === true ? "Ok" : "Cancel";
  log(result);
}
function jsPrompt() {
  const p = prompt("I am a Js prompt");
  log(p);
}
function log(msg) {
  const result = document.getElementById("dialog-response");
  result.innerHTML = msg;
}
