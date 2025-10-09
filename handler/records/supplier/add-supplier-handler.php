<?php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $supplier_name = trim($_POST['supplier_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $contact_number = trim($_POST['phone_number'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $supplier_type = trim($_POST['supplier_type'] ?? '');
    $product_category_id = $_POST['product_category_id'] ?? '';
    $payment_terms = trim($_POST['payment_terms'] ?? '');
    $note = trim($_POST['note'] ?? '');
    $deleted = 'no';

    if (!$supplier_name || !$contact_person || !$address || !$supplier_type || !$product_category_id || !$payment_terms) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "⚠️ Required fields are missing."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO supplier 
        (supplier_name, contact_person, contact_number, address, supplier_type, product_category_id, payment_terms, note, deleted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "SQL error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("sssssssss", 
        $supplier_name, $contact_person, $contact_number, 
        $address, $supplier_type, $product_category_id, 
        $payment_terms, $note, $deleted
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Supplier added successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to insert: " . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
