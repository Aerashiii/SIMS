<?php
header('Content-Type: application/json');
// ✅ Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

try {
    $query = "SELECT COUNT(*) AS total_rental_boxes FROM rental_box";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'data' => ['total_rental_boxes' => $row['total_rental_boxes']]]);
    } else {
        echo json_encode(['success' => true, 'data' => ['total_rental_boxes' => 0]]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
