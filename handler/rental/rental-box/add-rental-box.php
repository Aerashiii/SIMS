<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $box_number = $_POST['box_number'] ?? '';
    $size = $_POST['box_size'] ?? '';
    $width = $_POST['box_width'] ?? '';
    $length= $_POST['box_length'] ?? '';
    $rental_fee = $_POST['box_rental_fee'] ?? '';
    $quantity = $_POST['box_quantity'] ?? '';
    $status = $_POST['box_status'] ?? '';
    

    if (empty($box_number) || empty($size) || empty($width) || empty($length) || empty($rental_fee) || empty($quantity) || empty($status)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO rentalbox (box_number, box_size, width, length, rental_fee, quantity, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("isiiiis", $box_number, $size, $width, $length, $rental_fee, $quantity, $status);

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
