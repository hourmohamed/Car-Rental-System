<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if customer_id is passed in the URL
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Database connection
    $servername = "localhost"; // Replace with your server details
    $username = "root";        // Replace with your username
    $password = "";            // Replace with your password
    $dbname = "Car_Rental_System"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete all rentals for the given customer_id
    $delete_query = "DELETE FROM rental WHERE customer_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        echo "All rentals for this customer have been cleared.";
    } else {
        echo "Error clearing rentals: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid customer ID.";
}
?>
