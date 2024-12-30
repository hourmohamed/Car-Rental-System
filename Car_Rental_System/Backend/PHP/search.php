<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "109578HH";
$dbname = "Car_Rental_System";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input data
    $color = isset($_POST["color"]) ? htmlspecialchars($_POST["color"]) : null;
    $model = isset($_POST["model"]) ? htmlspecialchars($_POST["model"]) : null;
    $year = isset($_POST["year"]) && is_numeric($_POST["year"]) ? (int)$_POST["year"] : null;
    $capacity = isset($_POST["capacity"]) && is_numeric($_POST["capacity"]) ? (int)$_POST["capacity"] : null;

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

    // Process the results and store them in an array
    $carResults = [];
    while ($row = $result->fetch_assoc()) {
        $carResults[] = $row;
    }

    // Store the results in a session or pass them as a URL parameter
    session_start();
    $_SESSION['car_results'] = $carResults;

    $stmt->close();
    $conn->close();

    // Redirect to the results page
    header('Location: search_result.php');
    exit();
} else {
    die("Invalid request method.");
}
?>
