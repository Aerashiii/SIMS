<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Set header for JSON response
header('Content-Type: application/json');

try {
    // Decode the JSON payload
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    // Extract values safely
    $brandId = $input['brand_id'];
    $brandName = $input['brand_name'];
    $status = $input['status'];
   

    // Prepare the SQL statement
    $stmt = $conn->prepare("
        UPDATE brand
        SET brand_name = ?, status = ?
        WHERE brand_id = ?
    ");

    $stmt->bind_param(
        'ssi',
        $brandName,
        $status,
        $brandId
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Database update failed');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
