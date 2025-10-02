<?php
header('Content-Type: application/json; charset=utf-8');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$category_name = isset($_POST['category_name']) ? trim($_POST['category_name']) : '';
$category_status = isset($_POST['status']) ? trim($_POST['status']) : 'active';

if ($category_name === '') {
    echo json_encode(["success" => false, "message" => "Category name is required."]);
    exit;
}

if (mb_strlen($category_name) > 191) {
    echo json_encode(["success" => false, "message" => "Category name too long (max 191)."]);
    exit;
}

$deleted = 'no';

// Check duplicate
$check = $conn->prepare("SELECT category_id FROM category WHERE category_name = ? AND deleted = 'no' LIMIT 1");
$check->bind_param("s", $category_name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Category already exists."]);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// Insert category
$stmt = $conn->prepare("INSERT INTO category (category_name, status, deleted) VALUES (?, ?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "SQL prepare failed."]);
    exit;
}
$stmt->bind_param("sss", $category_name, $category_status, $deleted);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Category created successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Execution failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
