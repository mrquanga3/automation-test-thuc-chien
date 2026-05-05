document.addEventListener("DOMContentLoaded", function () {
  const script = document.createElement("script");
  script.src = "/socket.io/socket.io.min.js";
  document.head.appendChild(script);
  script.onload = function () {
    const currentURL = window.location.href;
    const socket = io();
    const userData = { page: currentURL };
    socket.emit("pageChange", userData);
  };
});
