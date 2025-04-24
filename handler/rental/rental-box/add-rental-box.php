<?php
// Set headers for JSON response
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection settings
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); // Ensure proper encoding

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Get POST data
$boxNumber = isset($_POST['box_number']) ? trim($_POST['box_number']) : '';
$boxSize = isset($_POST['box_size']) ? trim($_POST['box_size']) : '';
$rentalFee = isset($_POST['rental_fee']) ? trim($_POST['rental_fee']) : '';
$quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : 'active';

// Check if any required field is empty
if (empty($boxNumber) || empty($boxSize) || empty($rentalFee) || empty($quantity) || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// SQL query to insert rental box
$sql = "INSERT INTO rental_boxes (box_number, box_size, rental_fee, quantity, status) VALUES (?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Prepare failed: ' . $conn->error
    ]);
    exit;
}

// Bind parameters
$stmt->bind_param("ssdis", $boxNumber, $boxSize, $rentalFee, $quantity, $status);

// Execute query
if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Rental box added successfully!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error saving rental box: ' . $stmt->error
    ]);
}

// Close the connection
$stmt->close();
$conn->close();
?>
