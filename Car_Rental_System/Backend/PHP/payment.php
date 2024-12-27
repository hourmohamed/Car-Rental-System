<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $license_number = trim($_POST['license_number'] ?? '');  
    $address = trim($_POST['address'] ?? '');  
    $payment_method = $_POST['method'] ?? '';  

    if (!empty($license_number) && !empty($address) && !empty($payment_method)) {
        $servername = "127.0.0.1";
        $username_db = "root";
        $password_db = "109578HH";
        $db_name = "car_rental_system";

        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

         
        $insert_customer_stmt = $conn->prepare("INSERT INTO customer (license_number, address) VALUES (?, ?)");
        $insert_customer_stmt->bind_param("ss", $license_number, $address);
        $insert_customer_stmt->execute();
        $insert_customer_stmt->close();
        
         
        $insert_payment_stmt = $conn->prepare("INSERT INTO payment method VALUES (?)");
        $insert_payment_stmt->bind_param("s", $payment_method);
        $insert_payment_stmt->execute();
        $insert_payment_stmt->close();
        
        
        header("Location: ../../Frontend/HTML/customer_search.html");
        exit();

        $check_customer_stmt->close();
        $conn->close();
    } else {
        echo "License number, address, and payment method cannot be empty.";
    }
}
?>
