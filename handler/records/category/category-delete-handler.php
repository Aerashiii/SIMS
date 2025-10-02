<?php
// category-delete-handler.php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}

// accept form/urlencoded 'id'
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) {
    echo json_encode(['error' => 'Invalid category ID.']);
    exit;
}

$stmt = $conn->prepare("UPDATE category SET deleted = 'yes' WHERE category_id = ?");
if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
} else {
    echo json_encode(['error' => 'Failed to delete category.']);
}

$stmt->close();
$conn->close();
