// eslint-disable-next-line no-unused-vars
function bmical() {
  const gender = document.getElementById("gender").value;
  let heightm = document.getElementById("height").value;
  const weightw = document.getElementById("weight").value;
  const age = document.getElementById("age").value;
  const bodymass = document.getElementById("BMI");
  const profile = document.getElementById("profile");
  const bodyfat = document.getElementById("bfat");
  if (heightm <= 0 || weightw <= 0 || age <= 0) {
    /*
        Please provide an age between 2 and 120.
        Please provide positive height value.
        Please provide positive weight value.
        
        */

    document.getElementById("divResult").style.visibility = "hidden";
    bodymass.innerHTML = "Please provide all the necessary information!";

    document.getElementById("mens-alert").innerHTML =
      '<div class="large-12 columns"><div data-alert class="alert-box alert">Please provide all the necessary information!<a href="#" class="close">&times;</a></div> </div>';
  } else {
    document.getElementById("mens-alert").innerHTML = "";
    if (gender === "Male") {
      let sex, bfat;
      sex = 1;
      heightm = heightm / 100;
      bmi = weightw / (heightm * heightm);
      bmi = bmi.toFixed(1);
      let range = range1(bmi);
      //document.getElementById("result").innerHTML = "RESULTS:";
      bodymass.innerHTML = "Your BMI is " + bmi + " kg/m2 (" + range + ")";
      bfat = fatpercent(age, bmi, sex);

      bodyfat.innerHTML = "Your Body Fat is " + bfat;
    }
    if (gender === "Female") {
      $("#mens-alert").html("");
      var sex, bfat;
      sex = 0;
      heightm = heightm / 100;
      bmi = weightw / (heightm * heightm);
      bmi = bmi.toFixed(1);
      let range = range1(bmi);
      //document.getElementById("result").innerHTML = "RESULTS:";
      bodymass.innerHTML = "Your BMI is " + bmi + " kg/m2 (" + range + ")";
      bfat = fatpercent(age, bmi, sex);
      bodyfat.innerHTML = "Your Body Fat is " + bfat;
    }

    document.getElementById("divResult").style.visibility = "visible";
    profile.innerHTML = ` <b>${gender}, ${age} (yr), ${heightm * 100} (cm), ${weightw} (kg)</b>`;
  }
}

function fatpercent(age, bmi, sex) {
  let bodyfat;
  if (age <= 19) {
    bodyfat = 1.51 * bmi - 0.7 * age - 3.6 * sex + 1.4;
    if (bodyfat < 0) {
      bodyfat = 0;
    }
    return bodyfat;
  }
  if (age >= 20) {
    bodyfat = 1.39 * bmi - 0.16 * age - 10.34 * sex - 9;
    if (bodyfat < 0) {
      bodyfat = 0;
    }
    return bodyfat.toFixed(1);
  }
}
function range1(bmi) {
  const bmi_gauge_lower = 13;
  const bmi_gauge_upper = 43;

  const bmi_guage_range = bmi_gauge_upper - bmi_gauge_lower;

  console.log("bmi_guage_range", bmi_guage_range);
  const BMI_adjusted =
    bmi >= bmi_gauge_lower && bmi <= bmi_gauge_upper
      ? bmi
      : bmi < bmi_gauge_lower
      ? bmi_gauge_lower
      : bmi_gauge_upper;
  const dial_rotation = Math.round(((BMI_adjusted - bmi_gauge_lower) / bmi_guage_range) * 180.0, 1);

  const svg = mySvg(bmi, dial_rotation);

  let rangeb;
  if (bmi < 16) {
    rangeb = "Severe Thinness";
  } else if (bmi > 16 && bmi <= 17) {
    rangeb = "Moderate Thinness";
  } else if (bmi > 17 && bmi <= 18.5) {
    rangeb = "Mild Thinness";
  } else if (bmi > 18.5 && bmi <= 25) {
    rangeb = "Normal";
  } else if (bmi > 25 && bmi <= 30) {
    rangeb = "Overweight";
  } else if (bmi > 30 && bmi <= 35) {
    rangeb = "Obese Class I";
  } else if (bmi > 35 && bmi <= 40) {
    rangeb = "Obese Class II";
  } else {
    rangeb = "Obese Class III";
  }

  // xix

  document.getElementById("bmi-gauge").innerHTML = svg;

  return rangeb;
}

function clearall() {
  document.getElementById("BMI").innerHTML = "";
  document.getElementById("indicator").innerHTML = "";
  document.getElementById("profile").innerHTML = "";
  document.getElementById("bfat").innerHTML = "";

  //document.getElementById("res").style.border = "thick solid white";

  document.getElementById("divResult").style.visibility = "hidden";
  document.getElementById("bmi-gauge").innerHTML = "";
}

const mySvg = (bmi, gaugeLevel) => {
  return ` <svg
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    width="300px"
    height="163px"
    viewBox="0 0 300 163"
  >
    <g
      transform="translate(18,18)"
      style="font-family: arial, helvetica, sans-serif; font-size: 12px"
    >
      <defs>
        <marker
          id="arrowhead"
          markerWidth="10"
          markerHeight="7"
          refX="0"
          refY="3.5"
          orient="auto"
        >
          <polygon points="0 0, 10 3.5, 0 7"></polygon>
        </marker>
        <path
          id="curvetxt1"
          d="M-4 140 A140 140, 0, 0, 1, 284 140"
          style="fill: none"
        ></path>
        <path
          id="curvetxt2"
          d="M33 43.6 A140 140, 0, 0, 1, 280 140"
          style="fill: #none"
        ></path>
        <path
          id="curvetxt3"
          d="M95 3 A140 140, 0, 0, 1, 284 140"
          style="fill: #none"
        ></path>
        <path
          id="curvetxt4"
          d="M235.4 33 A140 140, 0, 0, 1, 284 140"
          style="fill: #none"
        ></path>
      </defs>
      <path
        d="M0 140 A140 140, 0, 0, 1, 6.9 96.7 L140 140 Z"
        fill="#bc2020"
      ></path>
      <path
        d="M6.9 96.7 A140 140, 0, 0, 1, 12.1 83.1 L140 140 Z"
        fill="#d38888"
      ></path>
      <path
        d="M12.1 83.1 A140 140, 0, 0, 1, 22.6 63.8 L140 140 Z"
        fill="#ffe400"
      ></path>
      <path
        d="M22.6 63.8 A140 140, 0, 0, 1, 96.7 6.9 L140 140 Z"
        fill="#008137"
      ></path>
      <path
        d="M96.7 6.9 A140 140, 0, 0, 1, 169.1 3.1 L140 140 Z"
        fill="#ffe400"
      ></path>
      <path
        d="M169.1 3.1 A140 140, 0, 0, 1, 233.7 36 L140 140 Z"
        fill="#d38888"
      ></path>
      <path
        d="M233.7 36 A140 140, 0, 0, 1, 273.1 96.7 L140 140 Z"
        fill="#bc2020"
      ></path>
      <path
        d="M273.1 96.7 A140 140, 0, 0, 1, 280 140 L140 140 Z"
        fill="#8a0101"
      ></path>
      <path d="M45 140 A90 90, 0, 0, 1, 230 140 Z" fill="#fff"></path>
      <circle cx="140" cy="140" r="5" fill="#666"></circle>
      <g style="paint-order: stroke; stroke: #fff; stroke-width: 2px">
        <text x="25" y="111" transform="rotate(-72, 25, 111)">16</text>
        <text x="30" y="96" transform="rotate(-66, 30, 96)">17</text>
        <text x="35" y="83" transform="rotate(-57, 35, 83)">18.5</text>
        <text x="97" y="29" transform="rotate(-18, 97, 29)">25</text>
        <text x="157" y="20" transform="rotate(12, 157, 20)">30</text>
        <text x="214" y="45" transform="rotate(42, 214, 45)">35</text>
        <text x="252" y="95" transform="rotate(72, 252, 95)">40</text>
      </g>
      <g style="font-size: 14px">
        <text><textPath xlink:href="#curvetxt1">Underweight</textPath></text>
        <text><textPath xlink:href="#curvetxt2">Normal</textPath></text>
        <text><textPath xlink:href="#curvetxt3">Overweight</textPath></text>
        <text><textPath xlink:href="#curvetxt4">Obesity</textPath></text>
      </g>
      <line
        x1="140"
        y1="140"
        x2="65"
        y2="140"
        stroke="#666"
        stroke-width="2"
        marker-end="url(#arrowhead)"
      >
        <animateTransform
          attributeName="transform"
          attributeType="XML"
          type="rotate"
          from="0 140 140"
          to="${gaugeLevel} 140 140"
          dur="1s"
          fill="freeze"
          repeatCount="1"
        ></animateTransform>
      </line>
      <text
        x="67"
        y="120"
        style="font-size: 30px; font-weight: bold; color: #000"
      >
        BMI = ${bmi}
      </text>
    </g>
  </svg>`;
};
