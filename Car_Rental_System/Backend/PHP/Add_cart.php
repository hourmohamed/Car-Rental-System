<?php
session_start();
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// // Debug the received GET parameters
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

// Check if customer_email is passed
// if (isset($_GET['email']) && !empty($_GET['email'])) {
//     $customer_email = $_GET['email'];

//     // Assuming $_SESSION['customer_search_results'] contains the customer data
//     if (isset($_SESSION['customer_search_results'])) {
//         $customer_search_results = $_SESSION['customer_search_results'];

//         // Find customer_id based on email
//         $customer_id = null;
//         foreach ($customer_search_results as $customer) {
//             if ($customer['email'] === $customer_email) {
//                 $customer_id = $customer['customer_id'];
//                 break;
//             }
//         }

//         // If no customer found
//         if ($customer_id === null) {
//             echo "<p>Customer ID not found for the provided email.</p>";
//             exit();
//         }
//     } else {
//         echo "<p>No customer search results found in session.</p>";
//         exit();
//     }
// } else {
//     echo "<p>Email is required to proceed.</p>";
//     exit();
// }
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    echo "<p><strong>Customer ID:</strong> " . htmlspecialchars($customer_id) . "</p>";
} else {
    echo "<p>Customer ID not found in session. Please log in.</p>";
    exit(); // Stop further processing if no customer_id
}

// Retrieve GET data for car details
$car_model = isset($_GET['model']) ? $_GET['model'] : null;
$car_year = isset($_GET['year']) ? $_GET['year'] : null;
$car_color = isset($_GET['color']) ? $_GET['color'] : null;
$car_seating_capacity = isset($_GET['seating_capacity']) ? $_GET['seating_capacity'] : null;

// Validate car details
if ($car_model && $car_year && $car_color && $car_seating_capacity) {
    // Database connection
    $servername = "localhost"; // Replace with your server details
    $username = "root";        // Replace with your username
    $password = "109578HH";            // Replace with your password
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

        // Check if the car is already in the cart for the customer
        $check_cart_query = "SELECT * FROM rental WHERE customer_id = ? AND car_id = ?";
        $check_cart_stmt = $conn->prepare($check_cart_query);
        $check_cart_stmt->bind_param("ii", $customer_id, $car_id);
        $check_cart_stmt->execute();
        $check_cart_result = $check_cart_stmt->get_result();

        if ($check_cart_result->num_rows > 0) {
            echo "<p>This car is already in your cart.</p>";
        } else {
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
                echo "<p>Car successfully added to your cart!</p>";
                // Redirect to the My Cart page with customer_id
                header("Location: ../../Frontend/HTML/MyCart.php?customer_id=" . $customer_id);
                exit();
            } else {
                echo "<p>Error inserting rental: " . $rental_stmt->error . "</p>";
            }

            $rental_stmt->close();
        }

        $check_cart_stmt->close();
    } else {
        echo "<p>No car found matching the provided details.</p>";
    }

    $car_stmt->close();
    $conn->close();
} else {
    echo "<p>Missing car details. Please try again.</p>";
}
?>
