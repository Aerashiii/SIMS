<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $contact_number = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $supplier_type = $_POST['supplier_type'] ?? '';
    $product_category_id = $_POST['product_category_id'] ?? '';
    $payment_terms = $_POST['payment_terms'] ?? '';
    $note = $_POST['note'] ?? '';

    if (empty($supplier_name) || empty($contact_person) || empty($contact_number) || empty($address) || empty($supplier_type) || empty($product_category_id) || empty($payment_terms)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO supplier (supplier_name, contact_person, contact_number, address, supplier_type, product_category_id, payment_terms, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssssssss", $supplier_name, $contact_person, $contact_number, $address, $supplier_type, $product_category_id, $payment_terms, $note);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Supplier added successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to execute query: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
