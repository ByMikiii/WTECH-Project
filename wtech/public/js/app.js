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
  const colorContainer = document.getElementById("selected-colors-container");

  let selectedColors = [];

  colorButtons.forEach((button) => {
    const color = button.style.backgroundColor;

    button.addEventListener("click", function () {
      this.classList.toggle("selected");

      if (selectedColors.includes(color)) {
        selectedColors = selectedColors.filter((c) => c !== color);
      } else {
        selectedColors.push(color);
      }

      colorContainer.innerHTML = "";

      selectedColors.forEach((clr) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "color[]";
        input.value = clr;
        colorContainer.appendChild(input);
      });
    });
  });



  const buttons_ = document.querySelectorAll(".product-size-select");
  buttons_.forEach((button) => {
    button.addEventListener("click", function () {
      buttons_.forEach((btn) => btn.classList.remove("selected"));
      this.classList.add("selected");

      const sizeInput = document.querySelector('input[name="size"]');
      sizeInput.value = this.dataset.size || this.innerText;
    });
  });

  const stars = document.querySelectorAll(".star");
  const rating_number = document.getElementsByName("rating");
  let selectedRating = 1;

  stars.forEach((s, index) => {
    s.style.fill = index < selectedRating ? "gold" : "none";
  });

  stars.forEach((star) => {
    star.addEventListener("click", function () {
      selectedRating = this.getAttribute("data-value");
      rating_number.value = selectedRating;
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

const reg_form = document.getElementById('registration-form');
if (reg_form) {
  reg_form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(reg_form);
    const data = {
      email: formData.get('email'),
      password: formData.get('password'),
      password_confirmation: formData.get('password_confirmation'),
    };

    if (data.password !== data.password_confirmation) {
      alert("Zadané heslá nie sú rovnaké.");
    }
    else {
      fetch('/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
      })
        .then(response => {
          return response.json().then(result => {
            if (response.ok) {
              alert(result.message);
              window.location.href = '/login';
            } else {
              alert('Chyba pri registrácii: ' + (result.message || 'Skontrolujte údaje.'));
            }
          });
        })
        .catch(error => {
          console.error('Chyba pri fetchi:', error);
          alert('Chyba spojenia so serverom.');
        });
    }
  });
}

document.getElementById("logout").addEventListener("click", () => {
  fetch('/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => {
    if (response.redirected) {
      alert("Odhlásenie prebehlo úspešne!");
      window.location.href = response.url;
    }
  })
});
