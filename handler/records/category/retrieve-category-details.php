<?php
// retrieve-category-details.php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Category ID not provided.']);
    exit;
}

$categoryId = intval($_GET['id']);

$sql = "SELECT category_id, category_name, status, date_created FROM category WHERE category_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $category = $result->fetch_assoc();
    echo json_encode($category);
} else {
    echo json_encode(['error' => 'Category not found.']);
}

$stmt->close();
$conn->close();
