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

  
  return true;
}

