function validateForm() {
    const license = document.getElementById("license_number").value;
    const address = document.getElementById("address").value;
    const method = document.getElementById("method").value;
  
    if(license == ""){
        alert("License can't be empty!");
      
      return false; 
    }

    if(address == ""){
        alert("Address can't be empty!");
      
      return false; 
    }

    if(method == ""){
        alert("Select a payment method!");
      
      return false; 
    }


    return true;
}