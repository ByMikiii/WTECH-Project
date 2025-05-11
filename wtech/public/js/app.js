// toggle mobile navbar with button
function toggleMobileNav() {
  const navElement = document.getElementById("mobile-nav");
  if (navElement.style.display === "block") {
    navElement.style.display = "none";
  } else {
    navElement.style.display = "block";
  }
}

// toggle mobile filter with buttons
function toggleMobileFilter() {
  const filterElement = document.getElementById("filter");
  const productsElement = document.getElementById("products");

  if (filterElement.style.display === "flex") {
    filterElement.style.display = "none";
    productsElement.style.display = "block";
  } else {
    filterElement.style.display = "flex";
    productsElement.style.display = "none";
  }
}

// replaces image element with hidden input including id to remvoe
function removeImage(id) {
  const element = document.getElementById(`product-image-${id}`);
  if (element) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'images-to-delete[]';
    input.value = id;
    element.replaceWith(input);
  }
}

function sortSubmit() {
  const sort = document.getElementById('sort').value;
  const sortInput = document.getElementById('sort-input');
  sortInput.value = sort;
  submitCombinedForm();
}

// merge filter and search form
function submitCombinedForm() {
  const filterForm = document.getElementById('filter');
  const searchForm = document.getElementById('search-form');

  const formData = new FormData();

  // filter params
  if (filterForm) {
    new FormData(filterForm).forEach((value, key) => {
      formData.append(key, value);
    });
  }

  // search param
  if (searchForm) {
    new FormData(searchForm).forEach((value, key) => {
      formData.append(key, value);
    });
  }

  const params = new URLSearchParams(formData).toString();
  window.location.href = `/filter?${params}`;
}

// set & show notification message
function showNotification(message) {
  const el = document.getElementById('notification');
  if (el) {
    el.textContent = message;
    el.style.display = 'block';
    el.style.opacity = '1';

    setTimeout(() => {
      el.style.opacity = '0';
      setTimeout(() => {
        el.style.display = 'none';
      }, 500);
    }, 5000);
  }
}

// automatically hide nav & filter when resizing
window.addEventListener("resize", () => {
  if (window.innerWidth > 770) {
    document.getElementById("mobile-nav").style.display = "none";
  }
  if (window.innerWidth <= 600) {
    document.getElementById("filter").style.display = "none";
    document.getElementById("products").style.display = "block";
  } else {
    document.getElementById("filter").style.display = "block";
    document.getElementById("products").style.display = "block";
  }
});


// size select buttons
document.addEventListener("DOMContentLoaded", function () {
  // on forms submit call combined submit function
  const searchForm = document.getElementById('search-form');
  const filterForm = document.getElementById('filter');

  if (searchForm) {
    searchForm.addEventListener('submit', function (event) {
      event.preventDefault();
      submitCombinedForm();
    });
  }
  if (filterForm) {
    filterForm.addEventListener('submit', function (event) {
      event.preventDefault();
      submitCombinedForm();
    });
  }



  // size select buttons
  const buttons = document.querySelectorAll(".size-select");
  if (buttons.length) {
    buttons.forEach((button) => {
      button.addEventListener("click", function () {
        this.classList.toggle("selected");
      });
    });
  }


  // filter colors
  const colorButtons = document.querySelectorAll(".color-select");
  const colorContainer = document.getElementById("selected-colors-container");
  let selectedColors = [];
  if (colorButtons.length && colorContainer) {
    // saves selected colors from backend
    const items = document.querySelectorAll('#selected-colors-container input');
    items.forEach(item => {
      selectedColors.push(item.value);
    })

    // onclick color
    colorButtons.forEach((button) => {
      const color = button.style.backgroundColor;
      button.addEventListener("click", function () {
        this.classList.toggle("selected");

        // push/remove from array
        if (selectedColors.includes(color)) {
          selectedColors = selectedColors.filter((c) => c !== color);
        } else {
          selectedColors.push(color);
        }

        // foreach selected color create hidden input in form
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
  }


  // onclick change size
  const buttons_ = document.querySelectorAll(".product-size-select");
  const sizeInput = document.querySelector('input[name="size"]');
  if (buttons_.length && sizeInput) {
    buttons_.forEach((button) => {
      button.addEventListener("click", function () {
        buttons_.forEach((btn) => btn.classList.remove("selected"));
        this.classList.add("selected");
        sizeInput.value = this.dataset.size || this.innerText;
      });
    });
  }


  // review clickable stars
  const stars = document.querySelectorAll(".star");
  const rating_number = document.getElementsByName("rating");
  let selectedRating = 1;
  if (stars.length && rating_number.length) {
    // color
    stars.forEach((s, index) => {
      s.style.fill = index < selectedRating ? "gold" : "none";
    });

    // onclick
    stars.forEach((star) => {
      star.addEventListener("click", function () {
        selectedRating = this.getAttribute("data-value");
        rating_number[0].value = selectedRating;
        stars.forEach((s, index) => {
          s.style.fill = index < selectedRating ? "gold" : "none";
        });
      });
    });
  }
});

//fetch registration
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

    if (data.password.length < 6) {
      showNotification("Heslo musí obsahovať aspoň 6 znakov.");
    }
    else {
      if (data.password !== data.password_confirmation) {
        showNotification("Zadané heslá nie sú rovnaké.");
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
                showNotification(result.message);
                window.location.href = '/';
              } else {
                showNotification('Chyba pri registrácii: ' + (result.message || 'Skontrolujte údaje.'));
              }
            });
          })
          .catch(error => {
            console.error('Chyba pri fetchi:', error);
            showNotification('Chyba spojenia so serverom.');
          });
      }
    }
  });
}

const orderForm = document.getElementById("order-form");
if (orderForm){
  orderForm.addEventListener("submit",(e) => {
    e.preventDefault();

    const formData = new FormData(orderForm);

    const data = {
      email: formData.get('email'),
      first_name: formData.get('first_name'),
      last_name: formData.get('last_name'),
      postal_code: formData.get('postal_code'),
      phone: formData.get('phone'),
      city: formData.get('city'),
      street: formData.get('street'),
      pay: formData.get('pay'),
      delivery: formData.get('delivery'),
    };
    console.log(data);
    fetch('/order', {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      return response.json().then(result => {
        if (response.ok) {
          showNotification(result.message);
          window.location.href = '/summary';
        } else {
          showNotification('Chyba pri zadaní údajov!');
        }
      });
    })
    .catch(error => {
      console.error('Chyba pri fetchi:', error);
      showNotification('Chyba pri zadaní údajov, skontrolujte údaje!');
    });
  });
}

//fetch editing profile
const edit_profile_form = document.getElementById("edit_profile-form");
if (edit_profile_form) {
  edit_profile_form.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(edit_profile_form);
    const data = {
      email: formData.get('email'),
      first_name: formData.get('first_name'),
      last_name: formData.get('last_name'),
      phone: formData.get('phone'),
      postal_code: formData.get('postal_code'),
      city: formData.get('city'),
      street: formData.get('street'),
      username: formData.get('username'),
    }

    fetch('/edit_profile', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(data => {
        showNotification(data.message);
        window.location.href = '/profile';
      })
      .catch(error => {
        showNotification("Skontrolujte si zadané údaje!");
      })
  })
}

//fetch change of password
const change_passwordForm = document.getElementById("change_password-form");
if (change_passwordForm) {
  change_passwordForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(change_passwordForm);
    const data = {
      current_password: formData.get('current_password'),
      new_password: formData.get('new_password'),
      password_confirmation: formData.get('retype_password'),
    };

    if (data.new_password.length < 6) {
      sendSessionNotification("Nové heslo musí obsahovať aspoň 6 znakov");
      showNotification("Nové heslo musí obsahovať aspoň 6 znakov");
    }

    else {
      if (data.new_password != data.password_confirmation) {
        showNotification("Nové heslo nie je zhodné s položkou Potvrdiť heslo!");
      }

      else {
        if (data.new_password == data.current_password) {
          showNotification("Nové heslo nemôže byť rovnaké ako to aktuálne");
        }

        else {
          fetch('/change_password', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
          })
            .then(response => response.json())
            .then(data => {
              sendSessionNotification(data.message);
              showNotification(data.message);
            })
        }
      }
    }
  });
}
