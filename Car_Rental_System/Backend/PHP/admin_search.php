<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "Car_Rental_System";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $color = $_POST["color"] ?? null;
    $model = $_POST["model"] ?? null;
    $year = $_POST["year"] ?? null;
    $capacity = $_POST["capacity"] ?? null;
    $plate_no = $_POST["Plate_Number"] ?? null;

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start building the query
    $query = "SELECT * FROM `car` WHERE 1=1"; // 1=1 ensures a valid base query
    $params = [];
    $types = "";

    if ($color) {
        $query .= " AND `color` = ?";
        $params[] = $color;
        $types .= "s";
    }
    if ($model) {
        $query .= " AND `model` = ?";
        $params[] = $model;
        $types .= "s";
    }
    if ($year) {
        $query .= " AND `year` = ?";
        $params[] = $year;
        $types .= "i";
    }
    if ($capacity) {
        $query .= " AND `seating_capacity` = ?";
        $params[] = $capacity;
        $types .= "i";
    }
    if ($plate_no) {
        $query .= " AND `plate_number` = ?";
        $params[] = $plate_no;
        $types .= "i";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Check and process the results
    if ($result && $result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            // echo "Car ID: " . $row["car_id"] . " | Model: " . $row["model"] . " | Year: " . $row["year"] . "<br>";
            header("../../Frontend/HTML/search_results_page.html");
            exit;
        }
    } else {
        echo '<script>
            alert("No cars found")
            window.location.href = "../../Frontend/HTML/admin_search.html";
            </script>';
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    die("Invalid request.");
}
?>
