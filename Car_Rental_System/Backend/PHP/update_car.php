<?php

$servername = "localhost"; 
$username = "root";
$password = "109578HH";
$dbname = "car_rental_system";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $color = $_POST["color"] ?? null;
    $model = $_POST["model"] ?? null; 
    $year = $_POST["year"] ?? null;
    $plate = $_POST["plate_number"];
    $status = $_POST["status"] ?? null;
    $price = is_numeric($_POST["price"]) ? $_POST["price"] : null;
    $capacity = is_numeric($_POST["capacity"]) ? $_POST["capacity"] : null;


    if (empty($plate)) {
        echo "Plate number is required to identify the car.";
        exit();
    }

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

    if ($result->num_rows === 0) {
        echo '<script>
            alert("Car with the given plate number does not exist")
            window.location.href = "../../Frontend/HTML/admin_update.html";
            </script>';
        // echo "Car with the given plate number does not exist.";
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();

    
    $updateFields = [];
    $params = [];
    $types = "";

    if (!empty($color)) {
        $updateFields[] = "color = ?";
        $params[] = $color;
        $types .= "s";
    }
    if (!empty($model)) {
        $updateFields[] = "model = ?";
        $params[] = $model;
        $types .= "s";
    }
    if (!empty($year)) {
        $updateFields[] = "`year` = ?";
        $params[] = $year;
        $types .= "s";
    }
    if (!empty($price)) {
        $updateFields[] = "price = ?";
        $params[] = $price;
        $types .= "d";
    }
    if (!empty($capacity)) {
        $updateFields[] = "seating_capacity = ?";
        $params[] = $capacity;
        $types .= "d";
    }
    if (!empty($status)) {
        $updateFields[] = "car_status = ?";
        $params[] = $status;
        $types .= "s";
    }

    if (empty($updateFields)) {
        echo "No updates provided.";
        $conn->close();
        exit();
    }

    $updateQuery = "UPDATE car SET " . implode(", ", $updateFields) . " WHERE plate_number = ?";
    $params[] = $plate;
    $types .= "s";

    $stmt = $conn->prepare($updateQuery);
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        die("Error preparing statement.");
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo '<script>
            alert("Car details updated!");
            window.location.href = "../../Frontend/HTML/admin_option.html";
        </script>';
    } else {
        error_log("Error executing statement: " . $stmt->error);
        echo "Error updating car details.";
    }

    $stmt->close();
    $conn->close();
}
?>
