<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = filter_var(trim($_POST['firstName'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');
    $phone_number = trim($_POST['phone'] ?? '');
 
    if (!empty($email) && !empty($password) && !empty($fname) && !empty($phone_number)) {

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        // Hash the password
        $hashed_password = md5($password);

        // Database connection
        $servername = "localhost";
        $username_db = "root";
        $password_db = "";
        $db_name = "Car_Rental_System";
        
        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Error preparing statement.");
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // If email already exists, redirect to the login page
        if ($result->num_rows > 0) {
            header("Location: ../../Frontend/HTML/customer_login.html?error=email_exists");
            exit;
        }

        // Insert the new customer into the database
        $stmt = $conn->prepare("INSERT INTO customer (customer_name , email, password, phone_number) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Error preparing statement.");
        }

        $stmt->bind_param("ssss", $fname, $email, $hashed_password, $phone_number);

        // Execute the statement
        if ($stmt->execute()) {
            // Retrieve the customer_id by querying the database using the email
            $customer_id_stmt = $conn->prepare("SELECT customer_id FROM customer WHERE email = ?");
            if ($customer_id_stmt === false) {
                error_log("Error preparing customer_id query: " . $conn->error);
                die("Error preparing customer_id query.");
            }

            $customer_id_stmt->bind_param("s", $email);
            $customer_id_stmt->execute();
            $result = $customer_id_stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $customer_id = $row['customer_id'];

                // Store the customer first name and customer ID in the session
                $_SESSION['fname'] = $fname;
                $_SESSION['customer_id'] = $customer_id;

                // Redirect to the customer search page with customer_id as a URL parameter
                header("Location: ../../Frontend/HTML/customer_search.html?customer_id=" . $customer_id);
                exit;
            } else {
                echo "Error: Customer ID not found.";
            }
        } else {
            error_log("Error executing statement: " . $stmt->error);
            echo "Registration failed. Please try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All fields (firstName, email, and password) cannot be empty.";
    }
}
?>
