console.log("The page was successfully loaded");

// log
//============
const inputLog = document.getElementById("input-log");
const buttonLog = document.getElementById("btn-log");

buttonLog.addEventListener("click", () => {
  if (inputLog.value) {
    const now = new Date();
    const message = `[console.log()] ${now.toISOString()} - ${inputLog.value}`;
    console.log(message);
  }
});

// Warn
//============
const inputWarn = document.getElementById("input-warn");
const buttonWarn = document.getElementById("btn-warn");

buttonWarn.addEventListener("click", () => {
  if (inputWarn.value) {
    const now = new Date();
    const message = `[console.warn()] ${now.toISOString()} - ${inputWarn.value}`;
    console.warn(message);
  }
});

// Error
//============
const inputError = document.getElementById("input-error");
const buttonError = document.getElementById("btn-error");

buttonError.addEventListener("click", () => {
  if (inputError.value) {
    const now = new Date();
    const message = `[console.error()] ${now.toISOString()} - ${inputError.value}`;
    console.error(message);
  }
});

// info
//============
const inputInfo = document.getElementById("input-info");
const buttonInfo = document.getElementById("btn-info");

buttonInfo.addEventListener("click", () => {
  if (inputInfo.value) {
    const now = new Date();
    const message = `[console.info()] ${now.toISOString()} - ${inputInfo.value}`;
    console.info(message);
  }
});

// debug
//============
const inputDebug = document.getElementById("input-debug");
const buttonDebug = document.getElementById("btn-debug");

buttonDebug.addEventListener("click", () => {
  if (inputDebug.value) {
    const now = new Date();
    const message = `[console.debug()] ${now.toISOString()} - ${inputDebug.value}`;
    console.debug(message);
  }
});

// table
//============
const inputTable = document.getElementById("input-table");
const buttonTable = document.getElementById("btn-table");

buttonTable.addEventListener("click", () => {
  if (inputTable.value) {
    const messages = inputTable.value.split(", ").map((text, index) => ({
      id: index + 1,
      text,
      date: new Date().toISOString()
    }));
    console.table(messages);
  }
});
