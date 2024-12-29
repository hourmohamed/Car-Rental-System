<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $servername = "127.0.0.1";
        $username_db = "root";
        $password_db = "";
        $db_name = "car_rental_system";

        $conn = new mysqli($servername, $username_db, $password_db, $db_name);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Connection failed.");
        }

        $stmt = $conn->prepare("SELECT password FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            if ($stored_password === md5($password) || password_verify($password, $stored_password)) {
                header("Location: ../../Frontend/HTML/customer_search.html");
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
