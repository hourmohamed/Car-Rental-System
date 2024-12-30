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
    $password = "109578HH";            // Replace with your password
    $dbname = "Car_Rental_System"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to join rental, customer, and car tables
    $query = "
        SELECT c.model, c.price, r.rental_date, r.car_id
        FROM rental r
        JOIN car c ON r.car_id = c.car_id
        JOIN customer cu ON r.customer_id = cu.customer_id
        WHERE r.customer_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if results exist
    if ($result->num_rows > 0) {
        $cars = [];
        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
        $_SESSION['reservation_cars'] = $cars; // Store the car details in session
    } else {
        $message = "No cars found for the given customer.";
    }

    $stmt->close();
    $conn->close();
} else {
    $message = "Invalid customer ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation Cart - Car Rental System</title>
  <link rel="stylesheet" href="../Styles/styles.css">
  <script src="../JS/MyCart.js"></script>
</head>
<body>
<nav class="navbar">
    <h1>Car Rental System</h1>
    <ul>
      <li><a href="../HTML/home_page.html">Home</a></li>
      
    </ul>
  </nav>
  <div class="cart-container">
    <h2>Your Reservation Cart</h2>
    
    <div id="cart-items">
      <!-- Cart items will be displayed here -->
      <?php
        if (isset($message)) {
            echo "<p>$message</p>";
        } else {
            if (isset($_SESSION['reservation_cars']) && !empty($_SESSION['reservation_cars'])) {
                foreach ($_SESSION['reservation_cars'] as $car) {
                    echo "
                    <div class='cart-item'>
                      <p>Model: " . htmlspecialchars($car['model']) . "</p>
                      <p>Price: $" . htmlspecialchars($car['price']) . "/day</p>
                      <p>Rental Date: " . htmlspecialchars($car['rental_date']) . "</p>
                    </div>
                    ";
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
        }
      ?>
    </div>

    <button onclick="clearCart()">Clear Cart</button>
    <button onclick="confirmReservation()">Confirm Reservation</button>
    
  </div>

  <script>
    // Function to clear the cart and delete all rental records
    // Function to calculate total amount from session data (cars stored in session)
function calculateTotalAmount() {
  // Assuming the total amount calculation is based on the car prices in the session
  let totalAmount = 0;

  // Assuming each car object in session contains a "price" field
  <?php
    // Pass the car prices from the session to JavaScript
    if (isset($_SESSION['reservation_cars'])) {
      $cars = $_SESSION['reservation_cars'];
      foreach ($cars as $car) {
        echo "totalAmount += " . $car['price'] . ";";
      }
    }
  ?>

  return totalAmount;
}

    function clearCart() {
      const customerId = new URLSearchParams(window.location.search).get('customer_id'); // Get the customer_id from the URL
      if (customerId) {
        // Send an AJAX request to delete the rentals related to the customer_id
        fetch('delete.php?customer_id=' + customerId)
          .then(response => response.text())
          .then(result => {
            alert(result); // Show the result of the operation
            window.location.reload(); // Reload the page to reflect the changes
          })
          .catch(error => console.error('Error:', error));
      }
    }
   
    
    function removeCar(carId) {
  const customerId = new URLSearchParams(window.location.search).get('customer_id');
  if (customerId && carId) {
    // Send an AJAX request to remove the car from the cart
    fetch('removeCar.php?customer_id=' + customerId + '&car_id=' + carId)
      .then(response => response.text())
      .then(result => {
        alert(result); // Show the result of the operation
        window.location.reload(); // Reload the page to reflect the changes
      })
      .catch(error => console.error('Error:', error));
  }
}
    // Function to confirm reservation
    function confirmReservation() {
  const customerId = new URLSearchParams(window.location.search).get('customer_id');
  if (!customerId) {
    alert('Invalid customer ID.');
    return;
  }

  // Assuming you have a function that calculates the total amount (e.g., calculateTotalAmount)
  const totalAmount = calculateTotalAmount(); // Implement this based on your pricing logic

  // Redirect to payment.html and pass necessary parameters via the URL
  window.location.href = `payment.html?customer_id=${customerId}&amount=${totalAmount}`;
}

  </script>
</body>
</html>
