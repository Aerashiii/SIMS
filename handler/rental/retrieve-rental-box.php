<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$searchQueryRaw = isset($_POST['query']) ? trim($_POST['query']) : '';
$searchQuery = "%$searchQueryRaw%";

$sql = "SELECT box_id, box_number, box_size, width, length, rental_fee, quantity, status FROM rentalbox WHERE status = 'active'";

if (!empty($searchQueryRaw)) {
    $sql .= " AND box_number LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$response = [];

if ($result && $result->num_rows > 0) {
    $boxes = [];
    while ($row = $result->fetch_assoc()) {
        $boxes[] = [
            'box_id' => $row['box_id'],
            'box_number' => $row['box_number'],
            'box_size' => $row['box_size'],
            'width' => $row['width'],
            'length' => $row['length'],
            'rental_fee' => $row['rental_fee'],
            'quantity' => $row['quantity'],
            'status' => $row['status']
        ];
    }
    echo json_encode(['success' => true, 'data' => $boxes]);
} else {
    echo json_encode(['success' => false, 'message' => 'No rental_box found.']);
}

$conn->close();
