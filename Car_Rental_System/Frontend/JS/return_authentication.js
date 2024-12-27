function validateForm() {
    const id = document.getElementById("customer_id").value;
    const model = document.getElementById("model").value;
   
  
    if(id == ""){
        alert("ID can't be empty!");
      
      return false; 
    }

    if(model == ""){
        alert("Model can't be empty!");
      
      return false; 
    }

    


    return true;
}