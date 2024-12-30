
<?php

$servername = "localhost"; 
$username = "root";
$password = "109578HH";
$dbname = "car_rental_system";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $color = $_POST["color"];
    $model = $_POST["model"]; 
    $year = $_POST["year"];
    $plate = $_POST["plate_number"];
    $price = $_POST["price"];
    $capacity = $_POST["capacity"];
    $status = $_POST["status"];
    //echo"g";
    $conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM car WHERE plate_number = ?");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Error preparing statement.");
        }

        $stmt->bind_param("s", $plate);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo"car in the system";
            $stmt->close();
        $conn->close();
        exit();
        }
        $stmt->close();


        $stmt = $conn->prepare("INSERT INTO car (color , model, `year`, plate_number, car_status, price, seating_capacity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Error preparing statement: " . $conn->error);
            die("Error preparing statement.");
        }

        // $stmt->bind_param("sssssss", $color, $model, $plate, $status, $price, $capacity);
        $stmt->bind_param("sssssss", $color, $model, $year, $plate, $status, $price, $capacity);



        if ($stmt->execute()) {
            echo '<script>
            alert("Car added!")
            window.location.href = "../../Frontend/HTML/admin_option.html";
            </script>';
        } else {
            error_log("Error executing statement: " . $stmt->error);
            echo "Error adding car to the system.";
        }
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>