<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['box_id'])) {
    echo json_encode(["success" => false, "message" => "Missing box ID"]);
    exit;
}

$box_id = intval($input['box_id']);

$stmt = $conn->prepare("DELETE FROM rental_box WHERE box_id = ?");
$stmt->bind_param("i", $box_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Box deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete box: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
