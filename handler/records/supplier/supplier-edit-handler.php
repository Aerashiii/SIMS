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

try {
    // Read JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    // Sanitize and assign
    $supplier_id         = intval($input['supplier_id'] ?? 0);
    $supplier_name       = trim($input['supplier_name'] ?? '');
    $contact_person      = trim($input['contact_person'] ?? '');
    $contact_number      = trim($input['contact_number'] ?? '');
    $address             = trim($input['address'] ?? '');
    $supplier_type       = trim($input['supplier_type'] ?? '');
    $product_category_id = intval($input['product_category_id'] ?? 0);
    $payment_terms       = trim($input['payment_terms'] ?? '');
    $note                = trim($input['note'] ?? '');

    if ($supplier_id <= 0) {
        throw new Exception('Invalid Supplier ID');
    }

    // Prepare statement
    $stmt = $conn->prepare("
        UPDATE supplier
        SET supplier_name = ?, contact_person = ?, contact_number = ?, 
            address = ?, supplier_type = ?, product_category_id = ?,
            payment_terms = ?, note = ?
        WHERE supplier_id = ?
    ");

    if (!$stmt) {
        throw new Exception('Query preparation failed: ' . $conn->error);
    }

    // ✅ Correct binding
    $stmt->bind_param(
        'sssssissi',
        $supplier_name,
        $contact_person,
        $contact_number,
        $address,
        $supplier_type,
        $product_category_id,
        $payment_terms,
        $note,
        $supplier_id
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Supplier updated successfully']);
    } else {
        throw new Exception('Database update failed: ' . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>
