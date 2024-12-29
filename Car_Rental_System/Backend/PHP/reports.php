<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root";
$password = "109578HH";
$dbname = "Car_Rental_System";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Initialize variables
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
    $car_plate_id = isset($_POST['car_plate_id']) ? $_POST['car_plate_id'] : null;
    $status_date = isset($_POST['status_date']) ? $_POST['status_date'] : null;
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
    $payment_end_date = isset($_POST['payment_end_date']) ? $_POST['payment_end_date'] : null;

    // All Reservations Within a Specified Period
    if ($start_date && $end_date) {
        $sql = "SELECT * FROM rental WHERE rental_date BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Display results
            echo "All reservations within the specified period:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Customer ID: " . $row["customer_id"] . " - Car ID: " . $row["car_id"] . " - Rental Date: " . $row["rental_date"] . "<br>";
            }
        } else {
            echo "No results found for the specified period.";
        }
    }

    // Reservations of a Specific Car
    if ($car_plate_id && $start_date && $end_date) {
        $sql = "SELECT * FROM rental WHERE car_id IN (SELECT car_id FROM car WHERE plate_id = '$car_plate_id') AND rental_date BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Display results
            echo "Reservations for car with plate ID $car_plate_id:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Customer ID: " . $row["customer_id"] . " - Rental Date: " . $row["rental_date"] . " - Return Date: " . $row["return_date"] . "<br>";
            }
        } else {
            echo "No reservations found for the specified car and period.";
        }
    }

    // Status of All Cars on a Specific Day
    if ($status_date) {
        $sql = "SELECT car_id, car_status FROM car WHERE car_id NOT IN (SELECT car_id FROM rental WHERE return_date > '$status_date')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Display results
            echo "Status of all cars on $status_date:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Car ID: " . $row["car_id"] . " - Status: " . $row["car_status"] . "<br>";
            }
        } else {
            echo "No results found for the specified date.";
        }
    }

    // Reservations of a Specific Customer
    if ($customer_id) {
        $sql = "SELECT * FROM rental WHERE customer_id = '$customer_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Display results
            echo "Reservations for customer ID $customer_id:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Car ID: " . $row["car_id"] . " - Rental Date: " . $row["rental_date"] . " - Return Date: " . $row["return_date"] . "<br>";
            }
        } else {
            echo "No reservations found for customer ID $customer_id.";
        }
    }

    // Daily Payments Within a Specific Period
    if ($start_date && $payment_end_date) {
        $sql = "SELECT * FROM payments WHERE payment_date BETWEEN '$start_date' AND '$payment_end_date'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Display results
            echo "Daily payments within the specified period:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Payment ID: " . $row["payment_id"] . " - Customer ID: " . $row["customer_id"] . " - Payment Date: " . $row["payment_date"] . " - Amount: " . $row["amount"] . "<br>";
            }
        } else {
            echo "No payments found for the specified period.";
        }
    }

} else {
    echo "Invalid request method.";
}

// Close connection
$conn->close();
?>
