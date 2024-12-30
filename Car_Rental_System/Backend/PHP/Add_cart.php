<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Debug the received GET parameters
echo "<pre>";
print_r($_GET);
echo "</pre>";

// Check if the request is submitted as GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve GET data
    $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
    $car_model = isset($_GET['model']) ? $_GET['model'] : null;
    $car_year = isset($_GET['year']) ? $_GET['year'] : null;
    $car_color = isset($_GET['color']) ? $_GET['color'] : null;
    $car_seating_capacity = isset($_GET['seating_capacity']) ? $_GET['seating_capacity'] : null;

    // Validate customer_id and car details
    if ($customer_id && $car_model && $car_year && $car_color && $car_seating_capacity) {
        // Database connection
        $servername = "localhost"; // Replace with your server details
        $username = "root";        // Replace with your username
        $password = "";            // Replace with your password
        $dbname = "Car_Rental_System"; // Replace with your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to get car_id based on car details
        $car_query = "SELECT car_id FROM car WHERE model = ? AND year = ? AND color = ? AND seating_capacity = ?";
        $car_stmt = $conn->prepare($car_query);

        if ($car_stmt === false) {
            die("Error preparing car query: " . $conn->error);
        }

        $car_stmt->bind_param("sisi", $car_model, $car_year, $car_color, $car_seating_capacity);
        $car_stmt->execute();
        $car_result = $car_stmt->get_result();

        if ($car_result->num_rows > 0) {
            // Fetch the car_id
            $car_row = $car_result->fetch_assoc();
            $car_id = $car_row['car_id'];

            // Calculate the return date (10 days from now)
            $return_date = date('Y-m-d', strtotime('+10 days'));

            // Insert into the rental table with the calculated return_date
            $rental_query = "INSERT INTO rental (customer_id, car_id, rental_date, return_date) 
                             VALUES (?, ?, NOW(), ?)";
            $rental_stmt = $conn->prepare($rental_query);

            if ($rental_stmt === false) {
                die("Error preparing rental query: " . $conn->error);
            }

            $rental_stmt->bind_param("iis", $customer_id, $car_id, $return_date);

            if ($rental_stmt->execute()) {
                echo "<p>Rental successfully added!</p>";
                // Redirect to a success page or display a message
                //header("Location: ../../Frontend/HTML/MyCart.html");
                header("Location: ../../Frontend/HTML/MyCart.php?customer_id=" . $customer_id);
                exit();
            } else {
                echo "<p>Error inserting rental: " . $rental_stmt->error . "</p>";
            }

            $rental_stmt->close();
        } else {
            echo "<p>No car found matching the provided details.</p>";
        }

        $car_stmt->close();
        $conn->close();
    } else {
        echo "<p>Missing data. Please try again.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>
