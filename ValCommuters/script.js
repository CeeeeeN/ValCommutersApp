//Toggle Password Visibility
document.querySelectorAll('.toggle-password').forEach(icon => {
  icon.addEventListener('click', () =>{
    const targetId = icon.getAttribute('data-target');
    const passwordInput = document.getElementById(targetId);

    if (!passwordInput) return; 

    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    icon.src = isPassword ? 'img/eyeOpen.png' : 'img/eyeClose.png';
  });
});

//Login Validation
const loginForm = document.querySelector('form[action="login"]') || document.querySelector('form.login');
if (loginForm){
  loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const emailOrPhone = loginForm.querySelector('input[type="text"]').value.trim();
    const password = loginForm.querySelector('input[type="password"]').value.trim();

    if (!emailOrPhone || !password){
      alert('Please fill in both Email/Phone and Password.');
      return;
    }

    // Email/Phone Validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    const phonePattern = /^(?:\+63|0)\d{10}$/;
    if (!emailPattern.test(emailOrPhone) && !phonePattern.test(emailOrPhone)){
      alert('Please enter a valid email or phone number.');
      return;
    }
  });
}

// Signup Validation
const signupForm = document.querySelector('form[action="signup"]') || document.querySelector('form.signup');
if (signupForm){
  signupForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const fullName = signupForm.querySelector('input[placeholder="Full Name"]').value.trim();
    const email = signupForm.querySelector('input[type="email"]').value.trim();
    const phone = signupForm.querySelector('input[type="tel"]').value.trim();
    const password = document.getElementById('createPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const terms = signupForm.querySelector('input[type="checkbox"]');

    if (!fullName || !email || !phone || !password || !confirmPassword){
      alert('Please fill in all fields.');
      return;
    }

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailPattern.test(email)){
      alert('Please enter a valid email address.');
      return;
    }

    const phonePattern = /^(?:\+63|0)\d{10}$/;
    if (!phonePattern.test(phone)){
      alert('Please enter a valid phone number.');
      return;
    }

    if (password.length < 6){
      alert('Password must be at least 6 characters long.');
      return;
    }

    if (password !== confirmPassword){
      alert('Passwords do not match.');
      return;
    }

    if (!terms.checked){
      alert('Please agree to the Terms & Conditions and Privacy Policy.');
      return;
    }

    alert('Sign up successful! Redirecting to login page...');
    setTimeout(() => {
      window.location.href = 'login.html';
    }, 1000);
  });
}

// Forgot Password Validation
const forgotForm = document.querySelector('form[action="forgot"]') || document.querySelector('form.forgot');
if (forgotForm){
  forgotForm.addEventListener('submit', (e) => {
    e.preventDefault();

    alert('Reset link has been sent to your email.');
    setTimeout(() => {
      window.location.href = 'login.html';
    }, 1000);
  });
}

// Reset Password Validation
const resetForm = document.querySelector('form[action="reset"]') || document.querySelector('form.reset');
if (resetForm) {
  resetForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    if (!newPassword || !confirmPassword){
      alert('Please fill in both password fields.');
      return;
    }

    if (newPassword.length < 6){
      alert('Password must be at least 6 characters long.');
      return;
    }

    if (newPassword !== confirmPassword){
      alert('Passwords do not match.');
      return;
    }

    alert('Password reset successful!');
    setTimeout(() => {
      window.location.href = 'login.html';
    }, 1000);
  });
}