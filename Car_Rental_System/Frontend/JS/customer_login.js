document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
  
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
  
    // Get registered users from localStorage
    const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];
  
    // Check if the email is registered
    const user = registeredUsers.find(user => user.email === email);
  
    if (!user) {
      // If email is not registered, redirect to the registration page
      alert('Email not registered! Please register first.');
      window.location.href = '../HTML/register.html'; // Redirect to the registration page
    } else if (user.password !== password) {
      // If email is registered but password is incorrect
      document.getElementById('error-message').style.display = 'block';
    } else {
      // If email and password are correct
      alert('Login successful! Redirecting to the MyCart page...');
      window.location.href = '../HTML/MyCart.html'; // Redirect to the MyCart page
    }
  });
  