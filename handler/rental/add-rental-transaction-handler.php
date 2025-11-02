<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
    exit;
}

$renter_name = $data['renter_name'];
$contact_number = $data['contact_number'];
$status = $data['status'];
$rental_start_date = $data['rental_start_date'];
$rental_end_date = $data['rental_end_date'];
$boxes = $data['boxes'];

// ✅ Insert renter
$stmt = $conn->prepare("INSERT INTO renter (renter_name, contact_number) VALUES (?, ?)");
$stmt->bind_param("ss", $renter_name, $contact_number);
if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to add renter"]);
    exit;
}
$renter_id = $stmt->insert_id;
$stmt->close();

// ✅ Create one rental transaction record (grouped)
$total_payment = array_sum(array_column($boxes, 'total'));
$total_quantity = array_sum(array_column($boxes, 'quantity'));

$sql = "INSERT INTO rental_transaction (renter_id, rented_quantity, payment, rental_start_date, rental_end_date, status, deleted)
        VALUES (?, ?, ?, ?, ?, ?, 'no')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iidsss", $renter_id, $total_quantity, $total_payment, $rental_start_date, $rental_end_date, $status);
if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to add rental transaction"]);
    exit;
}
$rental_transaction_id = $stmt->insert_id;
$stmt->close();

// ✅ Insert each rented box into rented_box_transaction
$insertBoxStmt = $conn->prepare("INSERT INTO rented_box_transaction (renter_id, rental_transaction_id, box_id, quantity) VALUES (?, ?, ?, ?)");
foreach ($boxes as $box) {
    $box_id = intval($box['id']);
    $quantity = intval($box['quantity']);
    $insertBoxStmt->bind_param("iiii", $renter_id, $rental_transaction_id, $box_id, $quantity);
    $insertBoxStmt->execute();
}
$insertBoxStmt->close();

echo json_encode(["success" => true, "message" => "Rental transaction added successfully."]);
$conn->close();
?>
