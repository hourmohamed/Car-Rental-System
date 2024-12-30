function validateForm() {
    const color = document.getElementById("color").value.trim();
    const model = document.getElementById("model").value.trim();
    const year = document.getElementById("year").value.trim();
    const capacity = document.getElementById("capacity").value.trim();
    const plate_number = document.getElementById("plate_number").value.trim();
    const status = document.getElementById("car_status").value;

    // Ensure at least one field is filled
    if (!color && !model && !year && !capacity && !plate_number) {
        alert("All fields can't be empty! Enter at least one.");
        return false;
    }

    // Check for required fields for status update
    if (!model || !plate_number || !year) {
        alert("Please enter the Model, Plate Number, and Year to update the car status.");
        return false;
    }

    // Basic validation passed
    alert("Form is valid! Proceeding with the update...");
    redirectToPage();
    return true;
}

function redirectToPage() {
    // Redirect or perform a success action
    window.location.href = "../HTML/admin_option.html"; 
}
