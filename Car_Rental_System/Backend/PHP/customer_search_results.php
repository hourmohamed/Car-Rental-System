<?php
session_start();

// Debug: print session data to check available values


// Retrieve the customer_id from the session (it should already be set if the user is logged in)
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    echo "<p><strong>Customer ID:</strong> " . htmlspecialchars($customer_id) . "</p>";
} else {
    echo "<p>Customer ID not found in session. Please log in.</p>";
    exit(); // Stop further processing if no customer_id
}

// Check if car results are available in the session
if (isset($_SESSION['car_results']) && !empty($_SESSION['car_results'])) {
    $carResults = $_SESSION['car_results'];

    // Display the results
    foreach ($carResults as $car) {
        // Build the dynamic URL with car details and customer_id
        $addToCartUrl = "../../Backend/PHP/Add_cart.php?" . http_build_query([
            'customer_id' => $customer_id, // Use the session customer_id
            'model' => $car['model'],
            'year' => $car['year'],
            'color' => $car['color'],
            'seating_capacity' => $car['seating_capacity']
        ]);

        echo "<div class='car-card'>";
        echo "<h3>" . htmlspecialchars($car['model']) . " (" . htmlspecialchars($car['year']) . ")</h3>";
        echo "<p><strong>Color:</strong> " . htmlspecialchars($car['color']) . "</p>";
        echo "<p><strong>Capacity:</strong> " . htmlspecialchars($car['seating_capacity']) . " people</p>";

        // Use an anchor tag for redirection
        echo "<a href='" . htmlspecialchars($addToCartUrl) . "' class='add-to-cart-button'>Add to Cart</a>";
        echo "</div>";
    }

    // Clear the session data after displaying the results
    unset($_SESSION['car_results']);
} else {
    echo "<p>No cars found matching your criteria.</p>";
}
?>
