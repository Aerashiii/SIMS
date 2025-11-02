<?php
// add_rental_box.php
session_start();

// Only allow logged-in users
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb"; // Change this if your DB name is different

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $box_number = $_POST['box_number'];
    $box_size = $_POST['box_size'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $rental_fee = $_POST['rental_fee'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO rental_box (box_number, box_size, width, length, rental_fee, quantity, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isiiiis", $box_number, $box_size, $width, $length, $rental_fee, $quantity, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Rental box added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add box: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
