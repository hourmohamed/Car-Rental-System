function validateForm() {
    const color = document.getElementById("color").value;
    const model = document.getElementById("model").value;
    const year = document.getElementById("year").value;
    const capacity = document.getElementById("capacity").value;
    const plate_number = document.getElementById('plate_number').value;
    let passed = true;
  
    if(color === "" && model ==="" && year === "" && capacity === "" && plate_number === ""){
        alert("All Field can't be empty! Enter at leat one");
      passed = false;
      return false; 
    }

    return true;
  }
  