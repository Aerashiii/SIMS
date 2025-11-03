<?php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// ✅ Connect to database
$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

try {
    // ✅ Sum of all rented quantities from rental_transaction (not deleted)
    $query = "
        SELECT 
            COALESCE(SUM(rented_quantity), 0) AS occupied_boxes
        FROM rental_transaction
        WHERE deleted = 'no'
    ";

    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'data' => ['occupied_boxes' => (int)$row['occupied_boxes']]
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'data' => ['occupied_boxes' => 0]
        ]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
