<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$deleted = 'no';
// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the request
    $brand_name = $_POST['brand_name'];
    $brand_status = $_POST['brand_status'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO brand (brand_name, status,deleted) VALUES (?, ?,?)");
    $stmt->bind_param("sss", $brand_name,  $brand_status,$deleted );  // 's' for string

    // Execute the query
    if ($stmt->execute()) {
        // Return success response as JSON
        echo json_encode(["success" => true]);
    } else {
        // Return failure response as JSON
        echo json_encode(["success" => false]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
