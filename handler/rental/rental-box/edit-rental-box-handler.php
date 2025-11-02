<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input.');
    }

    // Extract rental box fields
    $box_id = intval($input['box_id']);
    $box_number = intval($input['box_number']);
    $box_size = trim($input['box_size']);
    $width = intval($input['width']);
    $length = intval($input['length']);
    $rental_fee = intval($input['rental_fee']);
    $quantity = intval($input['quantity']);
    $status = trim($input['status']);

    // ✅ Check if box exists
    $check = $conn->prepare("SELECT box_id FROM rental_box WHERE box_id = ?");
    $check->bind_param('i', $box_id);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Box ID not found.");
    }
    $check->close();

    // ✅ Correct table name and binding types
    $stmt = $conn->prepare("
        UPDATE rental_box 
        SET box_number = ?, 
            box_size = ?, 
            width = ?, 
            length = ?, 
            rental_fee = ?, 
            quantity = ?, 
            status = ?
        WHERE box_id = ?
    ");

    if (!$stmt) {
        throw new Exception("SQL prepare failed: " . $conn->error);
    }

    // ✅ Correct type binding (i = integer, s = string)
    // order: int, string, int, int, int, int, string, int
    $stmt->bind_param(
        'isiiiisi',
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
        echo json_encode(["success" => true, "message" => "Box updated successfully."]);
    } else {
        throw new Exception("Update failed: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>
