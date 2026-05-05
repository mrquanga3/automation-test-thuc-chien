const navbarToggler = document.querySelector(".main-navbar .navbar-toggler");
const navbarCollapse = document.querySelector(".main-navbar .navbar-collapse");

if (!!navbarToggler && !!navbarCollapse) {
  document.querySelectorAll(".main-navbar .nav-link").forEach((e) => {
    e.addEventListener("click", () => {
      if (e.id && e.id === "examples-dropdown") {
        const section = document.getElementById("examples-dropdown");
        if (section) section.scrollIntoView({ behavior: "smooth" });
      } else {
        navbarToggler.classList.remove("active");
        navbarCollapse.classList.remove("show");
      }
    });
  });
  navbarToggler.addEventListener("click", function () {
    navbarToggler.classList.toggle("active");
  });
}

/*===== SCROLL SECTIONS ACTIVE LINK =====*/
const sections = document.querySelectorAll("section[id]");
window.addEventListener("scroll", scrollActive);

function scrollActive() {
  const scrollY = window.pageYOffset;

  sections.forEach((current) => {
    const sectionHeight = current.offsetHeight;
    const sectionTop = current.offsetTop - 90;
    const sectionId = current.getAttribute("id");

    const sectionSelector = document.querySelector(".navbar a[href*=" + sectionId + "]");

    if (sectionSelector) {
      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
        sectionSelector.classList.add("active");
      } else {
        sectionSelector.classList.remove("active");
      }
    }
  });
}

(function () {
  function acceptCookies() {
    const acceptButton = document.querySelector(".fc-cta-consent");

    if (acceptButton) {
      acceptButton.click();
      console.log("ACP1");
    }

    // const closeButton = document.querySelector("[aria-label='Close']");

    // if (closeButton) {
    //   closeButton.click();
    //   console.log("ACP2");
    // }

    // remove the ads setting
    const parentElement = document.querySelector(".google-revocation-link-placeholder");
    if (parentElement) {
      const childElements = parentElement.querySelectorAll("*");
      // Loop through the child elements and set display to "none"
      for (let i = 0; i < childElements.length; i++) {
        childElements[i].parentNode.removeChild(childElements[i]);
      }
      parentElement.parentNode.removeChild(parentElement);
    }
  }

  function checkAndAcceptCookies() {
    acceptCookies();
  }

  // Run the function immediately
  checkAndAcceptCookies();

  // Optionally, keep checking periodically for the consent dialog
  setInterval(checkAndAcceptCookies, 1000);
})();
