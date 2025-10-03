<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB Connection failed: " . $conn->connect_error]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$subcategoryId = intval($input['subcategory_id']);
$subcategoryName = trim($input['subcategory_name']);
$categoryId = intval($input['category_id']);
$status = trim($input['status']);

$stmt = $conn->prepare("UPDATE subcategory SET subcategory_name=?, category_id=?, status=? WHERE subcategory_id=?");
$stmt->bind_param("sisi", $subcategoryName, $categoryId, $status, $subcategoryId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Subcategory updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
