function validateForm() {
    const start_date = document.getElementById("star-date").value.trim();
    const car_id = document.getElementById("car-id").value.trim();
    const status_date = document.getElementById("status-date").value.trim();
    const customer_id = document.getElementById("customer-id").value.trim();
    const payment_end_date = document.getElementById("payment-end-date").value;

    // Ensure at least one field is filled
    if (!start_date && !car_id && !status_date && !customer_id && !payment_end_date) {
        alert("All fields can't be empty! Enter at least one.");
        return false;
      }
    return true;
}
