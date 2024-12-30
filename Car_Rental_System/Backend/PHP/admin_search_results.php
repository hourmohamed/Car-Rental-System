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
    <h2>Customer and Rental Data</h2>
    <p>Here are the customers and their rental details:</p>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "109578HH";
    $dbname = "Car_Rental_System";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to join customer and rental tables
    $query = "SELECT customer.customer_id, customer.customer_name, customer.email, customer.address, customer.phone_number, 
              customer.license_number, rental.rental_id, rental.rental_date, rental.return_date, rental.car_id
              FROM customer
              LEFT JOIN rental ON customer.customer_id = rental.customer_id";

    // Prepare and execute the query
    $result = $conn->query($query);

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='customer-card'>";
            echo "<h3>Customer ID: " . htmlspecialchars($row['customer_id']) . "</h3>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['customer_name']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
            echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
            echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($row['phone_number']) . "</p>";
            echo "<p><strong>License Number:</strong> " . htmlspecialchars($row['license_number']) . "</p>";
            echo "<p><strong>Rental ID:</strong> " . htmlspecialchars($row['rental_id']) . "</p>";
            echo "<p><strong>Rental Date:</strong> " . htmlspecialchars($row['rental_date']) . "</p>";
            echo "<p><strong>Return Date:</strong> " . htmlspecialchars($row['return_date']) . "</p>";
            echo "<p><strong>Car ID:</strong> " . htmlspecialchars($row['car_id']) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No rental data found for customers.</p>";
    }

    // Close the connection
    $conn->close();
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

    .customer-card {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 5px;
      background-color: #C8D9E6;
    }

    hr {
      border: 1px solid #ddd;
    }
  </style>
</body>
</html>
