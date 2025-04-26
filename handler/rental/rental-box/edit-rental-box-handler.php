<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    // Extract rental box fields from input
    $box_id = $input['box_id'];
    $box_number = $input['box_number'];
    $box_size = $input['box_size'];
    $width = $input['width'];
    $length = $input['length'];
    $rental_fee = $input['rental_fee'];
    $quantity = $input['quantity'];
    $status = $input['status'];

    // Prepare SQL UPDATE statement for rental box
    $stmt = $conn->prepare("
        UPDATE rentalbox 
        SET box_number = ?, box_size = ?, width = ?, length = ?, 
            rental_fee = ?, quantity = ?, status = ?
        WHERE box_id = ?
    ");

    if ($stmt === false) {
        throw new Exception('Query preparation failed: ' . $conn->error);
    }

    // Bind values (assuming width, length, rental_fee are decimal or float)
    $stmt->bind_param(
        'ssdddisi',
        $box_number,
        $box_size,
        $width,
        $length,
        $rental_fee,
        $quantity,
        $status,
        $box_id
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Update failed: ' . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
