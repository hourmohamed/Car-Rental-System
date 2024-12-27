function validateForm() {
  const firstName = document.getElementById("firstName").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const phone = document.getElementById("phone").value;
  let passed = true;

  
  if (firstName === "") {
    alert("First Name cannot be empty");
    passed = false;
  }

  if (email === "") {
    alert("Email cannot be empty");
    passed = false;
  }

  if (password === "") {
    alert("Password cannot be empty");
    passed = false;
  }

  if (phone === "") {
    alert("Phone number cannot be empty");
    passed = false;
  }

  // If any field validation failed, prevent form submission
  if (!passed) {
    return false;
  }

  // If validation passed, allow form submission
  alert("Form submitted successfully!");
  window.location.href = "/Frontend/HTML/customer_search.html";
  return true;
}
