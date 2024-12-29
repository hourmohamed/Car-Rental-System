<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root";
$password = "109578HH";
$dbname = "Car_Rental_System";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $id = $_POST["customer_id"];

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the car_id associated with the rental and customer
    $sql_fetch_car_id = "SELECT car.car_id FROM rental 
                         JOIN car ON car.car_id = rental.car_id 
                         WHERE rental.customer_id = '$id' AND car.model = '$model'";
    $result = $conn->query($sql_fetch_car_id);

    if ($result && $result->num_rows > 0) {
        $car = $result->fetch_assoc();
        $car_id = $car['car_id'];

        // Delete the rental record
        $sql_delete_rental = "DELETE FROM rental WHERE customer_id = '$id' AND car_id = '$car_id'";
        if ($conn->query($sql_delete_rental)) {
            // Update the car status to "available" instead of deleting
            $sql_update_car = "UPDATE car SET car_status = 'available' WHERE car_id = '$car_id'";
            if ($conn->query($sql_update_car)) {
                echo '<script>
                    alert("Car returned successfully.");
                    window.location.href = "../../Frontend/HTML/admin_search.html";
                    </script>';
            } else {
                echo "Error updating car status: " . $conn->error;
            }
        } else {
            echo "Error deleting rental record: " . $conn->error;
        }
    } else {
        echo '<script>
            alert("No matching rental found.");
            window.location.href = "../../Frontend/HTML/admin_search.html";
            </script>';
    }

    // Close the connection
    $conn->close();
} else {
    die("No POST data received.");
}
?>
