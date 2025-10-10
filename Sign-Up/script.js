document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirm-password");
  const form = document.querySelector("form");
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      const targetId = btn.getAttribute("data-toggle");
      const input = document.getElementById(targetId);

      if (input.type === "password") {
        input.type = "text";
        btn.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
               fill="none" stroke="#333" stroke-width="2" viewBox="0 0 24 24">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>`;
      } else {
        input.type = "password";
        btn.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
               fill="none" stroke="#333" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 19c-7 0-11-7-11-7a19.86 
            19.86 0 0 1 5.06-5.94M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
            <line x1="1" y1="1" x2="23" y2="23"/>
          </svg>`;
      }
    });
  });

  const passwordError = document.createElement("p");
  passwordError.className = "error-message";
  passwordInput.parentNode.appendChild(passwordError);

  const confirmError = document.createElement("p");
  confirmError.className = "error-message";
  confirmPasswordInput.parentNode.appendChild(confirmError);

  function validatePassword(password) {
    const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;
    return regex.test(password);
  }

  form.addEventListener("submit", function (e) {
    let valid = true;

    if (!validatePassword(passwordInput.value)) {
      passwordError.textContent =
        "Password must be at least 8 characters and include letters, numbers, and special characters.";
      valid = false;
    } else {
      passwordError.textContent = "";
    }

    if (passwordInput.value !== confirmPasswordInput.value) {
      confirmError.textContent = "Passwords do not match.";
      valid = false;
    } else {
      confirmError.textContent = "";
    }

    if (!valid) {
      e.preventDefault();
    }
  });
});
