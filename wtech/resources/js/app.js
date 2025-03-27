// toggle mobile navbar with button
function toggleMobileNav() {
  const navElement = document.getElementById("mobile-nav");
  if (navElement.style.display === "block") {
    navElement.style.display = "none";
  } else {
    navElement.style.display = "block";
  }
}

// size select buttons
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".size-select");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      this.classList.toggle("selected");
    });
  });
});

// color select buttons
document.addEventListener("DOMContentLoaded", function () {
  const colorButtons = document.querySelectorAll(".color-select");
  colorButtons.forEach((button) => {
    button.addEventListener("click", function () {
      this.classList.toggle("selected");
    });
  });
});
