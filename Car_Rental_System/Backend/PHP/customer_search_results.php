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
    // Check if car results are available in the session
    if (isset($_GET['customer_id'])) {
      $customer_id = $_GET['customer_id'];
      echo "Customer ID: " . htmlspecialchars($customer_id);
  } else {
      echo "Customer ID not found.";
  }
    if (isset($_SESSION['car_results']) && !empty($_SESSION['car_results'])) {
        $carResults = $_SESSION['car_results'];

        // Display the results
        foreach ($carResults as $car) {
            echo "<div class='car-card'>";
            echo "<h3>" . htmlspecialchars($car['model']) . " (" . htmlspecialchars($car['year']) . ")</h3>";
            echo "<p><strong>Color:</strong> " . htmlspecialchars($car['color']) . "</p>";
            echo "<p><strong>Capacity:</strong> " . htmlspecialchars($car['seating_capacity']) . " people</p>";
            echo "<form action='../../Frontend/HTML/MyCart.html' method='get'>";
            echo "<button type='submit'>Add to Cart</button>"; 
            echo "</form>";
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
