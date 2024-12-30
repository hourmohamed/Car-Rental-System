<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $servername = "localhost";
        $username_db = "root";
<<<<<<< HEAD
        $password_db = "";
        $db_name = "Car_Rental_System";
=======
        $password_db = "109578HH";
        $db_name = "car_rental_system";
>>>>>>> 551ccd3d34bf8bd02528dde6cdbb73c924d25714

        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

        // Query to fetch password and customer_id from the customer table
        $stmt = $conn->prepare("SELECT password, customer_id FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];
            $customer_id = $row['customer_id'];  // Retrieve customer_id

            // Verify password (both MD5 and password_verify)
            if ($stored_password === md5($password) || password_verify($password, $stored_password)) {
                // Store customer ID and email in session for later use
                $_SESSION['customer_id'] = $customer_id;
                $_SESSION['email'] = $email;

                // Redirect to customer_search.html with customer_id as a URL parameter
                header("Location: ../../Frontend/HTML/customer_search.html?customer_id=" . $customer_id);
                exit();
            } else {
                $_SESSION['error'] = "Invalid password.";
                header("Location: ../../Frontend/HTML/customer_login.html");
                exit();
            }
        } else {
            $_SESSION['error'] = "No user found with this email.";
            header("Location: ../../Frontend/HTML/customer_login.html");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        $_SESSION['error'] = "Email and password cannot be empty.";
        header("Location: ../../Frontend/HTML/customer_login.html");
        exit();
    }
}
?>
