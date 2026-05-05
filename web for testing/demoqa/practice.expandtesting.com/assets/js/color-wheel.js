const canvas = document.getElementById("picker");
const context = canvas.getContext("2d");
const x = canvas.width / 2;
const y = canvas.height / 2;
const radius = 150;
const counterClockwise = false;
let colorSelected;
const answer = document.getElementById("answers");

const colorsList = [
  {
    rgba: "rgba(255,0,0,1)",
    name: "red"
  },
  {
    rgba: "rgba(0,255,0,1)",
    name: "green"
  },
  {
    rgba: "rgba(0,0,255,1)",
    name: "blue"
  },
  {
    rgba: "rgba(255,20,147,1)",
    name: "pink"
  },
  {
    rgba: "rgba(0,0,0,1)",
    name: "black"
  },
  {
    rgba: "rgba(165,42,42,1)",
    name: "brown"
  },
  {
    rgba: "rgba(176,48,96,1)",
    name: "maroon"
  },
  {
    rgba: "rgb(160,32,240)",
    name: "purple"
  },
  {
    rgba: "rgb(190,190,190)",
    name: "gray"
  },
  {
    rgba: "rgb(255,255,0)",
    name: "yellow"
  },
  {
    rgba: "rgb(255,165,0)",
    name: "orange"
  },
  {
    rgba: "rgb(238,130,238)",
    name: "violet"
  },
  {
    rgba: "rgb(255,255,255)",
    name: "white"
  }
];
let colors;
const COLOR_COUNT = 6;

function initialize() {
  // 5 is the min no of colors for the Array, for every next question 1 color gets added
  colors = getRandomColors(COLOR_COUNT);
  const count = colors.length;

  for (let index = 0; index <= count; index += 1) {
    const step = 360 / count;
    const angle = index * step;
    const startAngle = ((angle - 1) * Math.PI) / 180;
    const endAngle = ((angle + step) * Math.PI) / 180;
    const color = colors[Math.round((angle / step) % colors.length)].rgba;
    drawArc(radius, startAngle, endAngle, color, 1, "black");
  }
  drawArc(10, 0, 360, "white", 3, "black");
  playGame();
}

function drawArc(radius, startAngle, endAngle, fillColor, strokeWidth, strokColor) {
  context.beginPath();
  context.moveTo(x, y);
  context.arc(x, y, radius, startAngle, endAngle, counterClockwise);
  context.closePath();
  context.fillStyle = fillColor;
  context.lineWidth = strokeWidth;
  context.strokeStyle = strokColor;
  context.stroke();
  context.fill();
}

function playGame() {
  canvas.removeAttribute("style");
  const deg = (360 / colors.length) * Math.round(Math.random() * 100);
  const css = "-webkit-transform: rotate(" + deg + "deg);-webkit-transition-duration: 1.5s;";
  canvas.setAttribute("style", css);
  // Adding 90 to degree , because our pointer is at y axis while angle starts from x axis
  const colorPartsmoved = Math.ceil(((deg + 90) % 360) / (360 / colors.length));
  colorSelected = colors[colors.length - colorPartsmoved].name;
  askQuestion();
}

// eslint-disable-next-line no-unused-vars
function resetGame() {
  canvas.removeAttribute("style");
}

function getRandomColors(maxColor) {
  return colorsList.sort(() => 0.5 - Math.random()).slice(0, maxColor);
}

function askQuestion() {
  answer.innerHTML = "";
  colors.forEach((color) => {
    const btnElement = document.createElement("button");
    btnElement.textContent = color.name;
    btnElement.onclick = (e) => checkAnswer(color.name);
    answer.appendChild(btnElement);

    // Tawfik (blank-html item)
    answer.appendChild(document.createTextNode("\u00A0"));
  });
}
function checkAnswer(answer) {
  if (answer === colorSelected) {
    /*if (confirm("Correct Answer. Do you want to Move to next level?")) {
            initialize();
        }*/
    // 2 lines by TNI
    //document.getElementById("result").innerHTML = "Correct Answer !";
    //sleep(1000);
    initialize();
    document.getElementById("result").innerHTML = "";
  } else {
    //alert("Incorrect Answer:" + answer);
    document.getElementById("result").innerHTML = "Incorrect Answer:" + answer;
  }
}

// eslint-disable-next-line no-unused-vars
function sleep(milliseconds) {
  const start = new Date().getTime();
  for (let i = 0; i < 1e7; i++) {
    if (new Date().getTime() - start > milliseconds) {
      break;
    }
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initialize();
});
