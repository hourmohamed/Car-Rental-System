// Check if the user is already registered when accessing the registration page
const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];

document.getElementById('registrationForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent the default form submission behavior

  const firstName = document.getElementById('firstName').value;
  const lastName = document.getElementById('lastName').value;
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const phone = document.getElementById('phone').value;

  // Check if the email is already registered
  const userExists = registeredUsers.some(user => user.email === email);

  if (userExists) {
    alert('This email is already registered. Please log in!');
    window.location.href = 'login.html'; // Redirect to login page if email is already registered
    return;
  }

  // Register new user by adding them to the registered users array
  const newUser = { firstName, lastName, email, password, phone };
  registeredUsers.push(newUser);

  // Save the updated users array to localStorage
  localStorage.setItem('registeredUsers', JSON.stringify(registeredUsers));

  alert('Registration successful! Redirecting to the home page...');
  window.location.href = 'home_page.html'; // Redirect to home page after successful registration
});
