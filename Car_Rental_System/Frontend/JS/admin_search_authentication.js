function validateForm() {
    const color = document.getElementById("color").value;
    const model = document.getElementById("model").value;
    const year = document.getElementById("year").value;
    const capacity = document.getElementById("capacity").value;
    const plate_number = document.getElementById('Plate_Number').value;
 
  
    if(color === "" && model ==="" && year === "" && capacity === "" && plate_number === ""){
        alert("All Field can't be empty! Enter at least one");
      
      return false; 
    }

    return true;
  }
  