<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "Car_Rental_System";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input data
    $color = isset($_POST["color"]) ? htmlspecialchars($_POST["color"]) : null;
    $model = isset($_POST["model"]) ? htmlspecialchars($_POST["model"]) : null;
    $year = isset($_POST["year"]) && is_numeric($_POST["year"]) ? (int)$_POST["year"] : null;
    $capacity = isset($_POST["capacity"]) && is_numeric($_POST["capacity"]) ? (int)$_POST["capacity"] : null;

    // Debugging: Print the input data to verify
    // var_dump($_POST); // Uncomment to check form data

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start building the query
    $query = "SELECT * FROM `car` WHERE 1=1"; // 1=1 ensures a valid base query
    $params = [];
    $types = "";

    if ($color) {
        $query .= " AND `color` = ?";
        $params[] = $color;
        $types .= "s";
    }
    if ($model) {
        $query .= " AND `model` = ?";
        $params[] = $model;
        $types .= "s";
    }
    if ($year) {
        $query .= " AND `year` = ?";
        $params[] = $year;
        $types .= "i";
    }
    if ($capacity) {
        $query .= " AND `seating_capacity` = ?";
        $params[] = $capacity;
        $types .= "i";
    }

    // Debugging: Output the query to check if it's formed correctly
    // echo $query; // Uncomment to check the query string

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Check and process the results
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Car ID: " . $row["car_id"] . " | Model: " . $row["model"] . " | Year: " . $row["year"] . "<br>";
            header("../../Frontend/HTML/customer_search.html");
            exit;
        }
    } else {
        // If no cars found, display an alert and redirect
        echo '<script>
            alert("No cars found matching the criteria.");
            window.location.href = "../../Frontend/HTML/customer_search.html";
        </script>';
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, show an error
    die("Invalid request method.");
}
?>
