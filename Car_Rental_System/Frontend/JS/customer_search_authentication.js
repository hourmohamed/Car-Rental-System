function validateForm() {
    const color = document.getElementById("color").value;
    const model = document.getElementById("model").value;
    const year = document.getElementById("year").value;
    const capacity = document.getElementById("capacity").value;
    let passed = true;
  
    if(color === "" && model ==="" && year === "" && capacity === ""){
        alert("All Field can't be empty! Enter at leat one");
      passed = false;
      return false; 
    }

    return true;
  }
  