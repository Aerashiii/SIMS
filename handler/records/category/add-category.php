<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}
$deleted = 'no';
// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the request
    $category_name = $_POST['category_name'] ?? null;
    $category_status = $_POST['status'] ?? null;

    if (!$category_name || !$category_status) {
        echo json_encode(["success" => false, "message" => "Invalid input data."]);
        exit;
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO category (category_name, status,deleted) VALUES (?, ?,?)");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "SQL preparation failed: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sss", $category_name, $category_status,$deleted);

    // Execute the query
    if ($stmt->execute()) {
        // Return success response as JSON
        echo json_encode(["success" => true, "message" => "Category created successfully."]);
    } else {
        // Return failure response as JSON
        echo json_encode(["success" => false, "message" => "Execution failed: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
