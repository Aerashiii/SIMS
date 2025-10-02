<?php
// category-edit-handler.php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// read JSON body
$raw = file_get_contents('php://input');
$input = json_decode($raw, true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$categoryId = isset($input['category_id']) ? intval($input['category_id']) : 0;
$categoryName = isset($input['category_name']) ? trim($input['category_name']) : '';
$status = isset($input['status']) ? trim($input['status']) : 'active';

if ($categoryId <= 0 || $categoryName === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare("UPDATE category SET category_name = ?, status = ? WHERE category_id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param('ssi', $categoryName, $status, $categoryId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category updated']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Update failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
