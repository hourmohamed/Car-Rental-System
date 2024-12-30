<?php
session_start();

if (isset($_GET['customer_id']) && isset($_GET['car_id'])) {
    $customer_id = $_GET['customer_id'];
    $car_id = $_GET['car_id'];

    // Check if the customer has a reservation cart in the session
    if (isset($_SESSION['reservation_cars'])) {
        // Find the car with the given car_id and remove it from the session
        foreach ($_SESSION['reservation_cars'] as $index => $car) {
            if ($car['car_id'] == $car_id) {
                unset($_SESSION['reservation_cars'][$index]);
                // Re-index the array after removal
                $_SESSION['reservation_cars'] = array_values($_SESSION['reservation_cars']);
                header("Location: ../../Frontend/HTML/MyCart.php?customer_id=" . $customer_id);
                echo "Car removed from your cart.";
                exit();
            }
        }

        echo "Car not found in your cart.";
    } else {
        echo "Your cart is empty.";
    }
} else {
    echo "Invalid request.";
}
?>
