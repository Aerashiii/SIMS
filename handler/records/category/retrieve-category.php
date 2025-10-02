<?php
// retrieve-category.php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT category_id, category_name, date_created, status FROM category WHERE deleted='no' ORDER BY category_id DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => "SQL prepare failed: " . $conn->error]);
    exit;
}

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => "Execution failed: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
$category_data = [];

while ($row = $result->fetch_assoc()) {
    // Format date
    if (!empty($row['date_created'])) {
        $row['date_created'] = date("F j, Y", strtotime($row['date_created']));
    }
    $category_data[] = $row;
}

echo json_encode(['success' => true, 'data' => $category_data]);

$stmt->close();
$conn->close();
