function validateForm() {
    // car-color
    // car-model
    // car-year
    // plate-number
    // car-price
    // car-capacity
    // car-status
    const color = document.getElementById("car-color").value;
    const model = document.getElementById("car-model").value;
    const year = document.getElementById("car-year").value;
    const plate = document.getElementById("plate-number").value;
    const capacity = document.getElementById("car-capacity").value;
    const status = document.getElementById("car-status").value;
    const price = document.getElementById("car-price").value;
   
    passed = true

    if (color === "") {
        alert("Color cannot be empty");
        passed = false;
        return false; 
    }

    if (model === "") {
        alert("Model cannot be empty");
        passed = false;
        return false; 
    }

    if (year === "") {
        alert("Year cannot be empty");
        passed = false;
        return false; 
    }

    if (plate === "") {
        alert("Plate number cannot be empty");
        passed = false;
        return false; 
    }
  
    if (capacity === "") {
        alert("Capacity cannot be empty");
        passed = false;
        return false; 
    }
   

    if (status === "") {
        alert("Status cannot be empty");
        passed = false;
        return false; 
    }
  
    if (price === "") {
        alert("Price cannot be empty");
        passed = false;
        return false; 
    }
    
    return true;
  }
  
  