<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $servername = "127.0.0.1";
        $username_db = "root";
        $password_db = "109578HH";
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

         
            if ($stored_password === md5($password)) {
                $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE customer SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $new_hashed_password, $email);
                $update_stmt->execute();
                $update_stmt->close();

                // header("Location: login_redirection.php");
                header("Location: ../../Frontend/HTML/home_page.html");
                exit();
            } elseif (password_verify($password, $stored_password)) {
                // header("Location: login_redirection.php");
                header("Location: ../../Frontend/HTML/home_page.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Email and password cannot be empty.";
    }
}
?>

