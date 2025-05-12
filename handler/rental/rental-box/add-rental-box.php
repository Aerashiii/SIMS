<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Enable detailed error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

header('Content-Type: application/json');

$deleted = 'no';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $box_number = isset($_POST['box_number']) ? (int)$_POST['box_number'] : 0;
    $size = trim($_POST['box_size'] ?? '');
    $width = isset($_POST['box_width']) ? (int)$_POST['box_width'] : 0;
    $length = isset($_POST['box_length']) ? (int)$_POST['box_length'] : 0;
    $rental_fee = isset($_POST['box_rental_fee']) ? (int)$_POST['box_rental_fee'] : 0;
    $quantity = isset($_POST['box_quantity']) ? (int)$_POST['box_quantity'] : 0;
    $status = trim($_POST['box_status'] ?? '');

    // Validate required fields
    if (
        empty($box_number) || empty($size) || empty($width) ||
        empty($length) || empty($rental_fee) || empty($quantity) || empty($status)
    ) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO rentalbox 
        (box_number, box_size, width, length, rental_fee, quantity, status, deleted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL statement: " . $conn->error]);
        exit();
    }

    // Corrected parameter types: i = integer, s = string
    $stmt->bind_param("isiiiiss", 
        $box_number, $size, $width, $length, $rental_fee, $quantity, $status, $deleted
    );

    // Execute and return response
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Box rental added successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to execute query: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
