function validateForm() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  passed = true

  
  if (email === "") {
      alert("Email cannot be empty");
      passed = false;
      return false; 
  }

  if (password === "") {
      alert("Password cannot be empty");
      passed = true;
      return false; 
    }

  if (passed) {
    // Redirect to customer_search page after successful validation
    window.location.href = "../../Frontend/HTML/customer_search.html"; // Adjust the URL as needed
  }
  return passed;
}

