<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the POST data
    $license_number = trim($_POST['license_number'] ?? '');  
    $address = trim($_POST['address'] ?? '');  
    $payment_method = $_POST['method'] ?? '';  

    // Check if all fields are provided
    if (!empty($license_number) && !empty($address) && !empty($payment_method)) {
        $servername = "localhost";
        $username_db = "root";
        $password_db = "109578HH";
        $db_name = "Car_Rental_System";

        // Create a database connection
        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        // Check connection
        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

        // Update the customer address
        $update_customer_stmt = $conn->prepare("UPDATE customer SET address = ? WHERE license_number = ?");
        if (!$update_customer_stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $update_customer_stmt->bind_param("ss", $address, $license_number);
        $update_customer_stmt->execute();
        $update_customer_stmt->close();

        // Get the customer_id based on the license_number
        $get_customer_stmt = $conn->prepare("SELECT customer_id FROM customer WHERE license_number = ?");
        if (!$get_customer_stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $get_customer_stmt->bind_param("s", $license_number);
        $get_customer_stmt->execute();
        $get_customer_stmt->bind_result($customer_id);
        $get_customer_stmt->fetch();
        $get_customer_stmt->close();

        if (!$customer_id) {
            die("Customer not found.");
        }

        // Insert rental record and get the rental_id
        $insert_rental_stmt = $conn->prepare("INSERT INTO rental (rental_date, customer_id) VALUES (CURDATE(), ?)");
        if (!$insert_rental_stmt) {
            die("Error preparing rental statement: " . $conn->error);
        }
        $insert_rental_stmt->bind_param("i", $customer_id);
        $insert_rental_stmt->execute();

        // Get the rental_id for the newly inserted rental record
        $rental_id = $conn->insert_id;
        $insert_rental_stmt->close();

        // Insert payment record
        $insert_payment_stmt = $conn->prepare("INSERT INTO payment (method, date, rental_id) VALUES (?, CURDATE(), ?)");
        if (!$insert_payment_stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $insert_payment_stmt->bind_param("si", $payment_method, $rental_id);
        $insert_payment_stmt->execute();
        $insert_payment_stmt->close();

        // Close the database connection
        $conn->close();

        // Redirect to the final page after successful operation
        header("Location: ../../Frontend/HTML/final_page.html");
        exit();
    } else {
        echo "License number, address, and payment method cannot be empty.";
    }
}
?>
