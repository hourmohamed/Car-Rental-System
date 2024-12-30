
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root";
$password = "109578HH";
$dbname = "Car_Rental_System";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password_field = $_POST["password"]; 
    $hashed_password_field = md5($password_field); 
    //echo"g";
    $conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT `password` FROM `admin` WHERE `email` = '$email'";


$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"]; 
       

        // echo $hashed_password;
        // echo $hashed_password_field;

        if ($hashed_password === $password_field) {
            echo '<script>
            alert("Welcome")
            window.location.href = "../../Frontend/HTML/admin_option.html";
            </script>';
            //redirect
        } else {
            // Invalid password
            echo '<script>
            alert("Invalid password")
            window.location.href = "../../Frontend/HTML/admin_login.html";
            </script>';
        }
    } else {
        echo '<script>
            alert("No user found")
            window.location.href = "../../Frontend/HTML/admin_login.html";
            </script>';
    }
} else {
    echo "Error: " . $conn->error; 
}


$conn->close();
} else {
    die("No POST data received.");
}


?>
