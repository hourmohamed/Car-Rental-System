function validateForm() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  if (email === "") {
    alert("Email cannot be empty");
    return false; // Prevent form submission
  }

  if (password === "") {
    alert("Password cannot be empty");
    return false; // Prevent form submission
  }

  // Allow form submission to the PHP script
  return true;
}
