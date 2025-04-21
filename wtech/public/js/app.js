// toggle mobile navbar with button
function toggleMobileNav() {
  const navElement = document.getElementById("mobile-nav");
  if (navElement.style.display === "block") {
    navElement.style.display = "none";
  } else {
    navElement.style.display = "block";
  }
}

// toggle mobile filter with button
function toggleMobileFilter() {
  const filterElement = document.getElementById("mobile-filter");
  console.log(filterElement.style.display)
  if (filterElement.style.display === "none") {
    filterElement.style.display = "flex";
  } else {
    filterElement.style.display = "none";
  }
  console.log(filterElement.style.display)
}

// automatically hide nav & filter when resizing
window.addEventListener("resize", () => {
  if (window.innerWidth > 770) {
    document.getElementById("mobile-nav").style.display = "none";
  }
  if (window.innerWidth > 600) {
    document.getElementById("mobile-filter").style.display = "none";
  }
});


// size select buttons
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".size-select");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      this.classList.toggle("selected");
    });
  });

  const colorButtons = document.querySelectorAll(".color-select");
  colorButtons.forEach((button) => {
    button.addEventListener("click", function () {
      this.classList.toggle("selected");
      if (selectedColors.includes(color)) {
        selectedColors = selectedColors.filter((c) => c !== color);
      } else {
        selectedColors.push(color);
      }
      colorInput.value = selectedColors.join(",");
    });
  });

  const buttons_ = document.querySelectorAll(".product-size-select");
  buttons_.forEach((button) => {
    button.addEventListener("click", function () {
      buttons_.forEach((btn) => btn.classList.remove("selected"));
      this.classList.add("selected");
    });
  });

  const stars = document.querySelectorAll(".star");
  let selectedRating = 1;

  stars.forEach((s, index) => {
    s.style.fill = index < selectedRating ? "gold" : "none";
  });

  stars.forEach((star) => {
    star.addEventListener("click", function () {
      selectedRating = this.getAttribute("data-value");
      stars.forEach((s, index) => {
        s.style.fill = index < selectedRating ? "gold" : "none";
      });
    });
  });

  document.getElementById("review-form").addEventListener("submit", function (event) {
    event.preventDefault();
    const reviewText = document.getElementById("review-text").value;
    console.log("Rating:", selectedRating, "Review:", reviewText);
  });
});
