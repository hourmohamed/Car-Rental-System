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
  <!-- Navigation Bar -->
  <nav class="navbar">
    <a href="../../Frontend/HTML/admin_option.html">Back to Admin Options</a>
  </nav>

  <div class="results-container">
    <h2>Search Results</h2>
    <p>Here are the cars that match your search criteria:</p>

    <?php
    // Check if car results are available in the session
    if (isset($_SESSION['car_results']) && !empty($_SESSION['car_results'])) {
        $carResults = $_SESSION['car_results'];

        // Display the results
        foreach ($carResults as $car) {
            echo "<div class='car-card'>";
            echo "<h3>" . htmlspecialchars($car['model']) . " (" . htmlspecialchars($car['year']) . ")</h3>";
            echo "<p><strong>Color:</strong> " . htmlspecialchars($car['color']) . "</p>";
            echo "<p><strong>Capacity:</strong> " . htmlspecialchars($car['seating_capacity']) . " people</p>";
            echo "</div>";
        }

        // Clear the session data after displaying the results
        unset($_SESSION['car_results']);
    } else {
        echo "<p>No cars found matching your criteria.</p>";
    }
    ?>
  </div>

  <style>
    /* Navigation Bar Styling */
    .navbar {
      background-color: #2F4156;
      padding: 1rem;
      display: flex;
      justify-content: flex-start;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      padding: 0.5rem 1rem;
      font-weight: bold;
    }

    .navbar a:hover {
      background-color: #567C8D;
      border-radius: 5px;
    }

    /* General Styling */
    .results-container {
      padding: 20px;
    }

    .car-card {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 5px;
      background-color: #C8D9E6;
    }
  </style>
</body>
</html>
