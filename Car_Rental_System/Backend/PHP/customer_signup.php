<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = filter_var(trim($_POST['firstName'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
    // $lname = filter_var(trim($_POST['lastName'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');
    $phone_number = trim($_POST['phone'] ?? '');
 
    if (!empty($email) && !empty($password) && !empty($fname) && !empty($phone_number)) {

       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        
        $hashed_password = md5($password);

        
        $servername = "127.0.0.1";
        $username_db = "root";
        $password_db = "109578HH";
        $db_name = "car_rental_system";
        
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

        // if ($result->num_rows > 0) {
        //     echo "User with this email already exists.";
        //     $stmt->close();
        //     $conn->close();
        //     exit;
        // }

        if ($result->num_rows > 0) {
            // Redirect to login page if the email already exists
            header("Location: ../../Frontend/HTML/customer_login.html?error=email_exists");
            exit;
        }
        
        $stmt = $conn->prepare("INSERT INTO customer (customer_name , email, password, phone_number) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Error preparing statement.");
        }

        $stmt->bind_param("ssss", $fname, $email, $hashed_password, $phone_number);

        if ($stmt->execute()) {
            $_SESSION['fname'] = $fname;
            
            // header("Location: signup_redirection.php");
            header("Location: ../../Frontend/HTML/home_page.html");
            exit; 
        } else {
            error_log("Error executing statement: " . $stmt->error);
            echo "Registration issue.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All fields (fname, email, and password) cannot be empty.";
    }
}
?>
