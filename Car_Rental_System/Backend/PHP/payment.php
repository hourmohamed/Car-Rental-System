<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $license_number = trim($_POST['license_number'] ?? '');  
    $address = trim($_POST['address'] ?? '');  
    $payment_method = $_POST['method'] ?? '';  

    if (!empty($license_number) && !empty($address) && !empty($payment_method)) {
        $servername = "127.0.0.1";
        $username_db = "root";
        $password_db = "";
        $db_name = "car_rental_system";

        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

       
        $update_customer_stmt = $conn->prepare("UPDATE customer SET address = ? WHERE license_number = ?");
        if (!$update_customer_stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $update_customer_stmt->bind_param("ss", $address, $license_number);
        $update_customer_stmt->execute();
        $update_customer_stmt->close();

       


        $insert_rental_stmt = $conn->prepare("INSERT INTO rental (rental_date, customer_id) VALUES (CURDATE(), ?)");
        if (!$insert_rental_stmt) {
            die("Error preparing rental statement: " . $conn->error);
        }
        $insert_rental_stmt->bind_param("s", $license_number);
        $insert_rental_stmt->execute();

        $rental_id = $conn->insert_id;
        $insert_rental_stmt->close();


        $insert_payment_stmt = $conn->prepare("INSERT INTO payment (method, date) VALUES (?, CURDATE())");
        if (!$insert_payment_stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $insert_payment_stmt->bind_param("s", $payment_method);
        $insert_payment_stmt->execute();
        $insert_payment_stmt->close();

       
        $conn->close();
        header("Location: ../../Frontend/HTML/final_page.html");
        exit();
    } else {
        echo "License number, address, and payment method cannot be empty.";
    }
}
?>
