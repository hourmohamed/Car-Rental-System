<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results</title>
  <link rel="stylesheet" href="../../Frontend/Styles/search_results.css">
</head>
<body>
  <div class="results-container">
    <h2>Search Results</h2>
    <p>Here are the cars that match your search criteria:</p>

    <?php
    // Check if customer_id is passed in the URL
    if (isset($_GET['customer_id'])) {
        $customer_id = $_GET['customer_id'];
        $_SESSION['customer_id'] = $customer_id; // Store the customer_id in the session if needed
        echo "<p><strong>Customer ID:</strong> " . htmlspecialchars($customer_id) . "</p>";
    } else {
        echo "<p>Customer ID not found in the URL.</p>";
    }

    // Check if car results are available in the session
    if (isset($_SESSION['car_results']) && !empty($_SESSION['car_results'])) {
        $carResults = $_SESSION['car_results'];

        // Display the results
        foreach ($carResults as $car) {
            // Build the dynamic URL with car details
            $addToCartUrl = "../../Backend/PHP/Add_cart.php?" . http_build_query([
                'customer_id' => $customer_id,
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
  </div>
</body>
</html>
