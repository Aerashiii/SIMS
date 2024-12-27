<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

try {
    // Read JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    // Get the values from the input
    $supplier_id = $input['supplier_id'];
    $supplier_name = $input['supplier_name'];
    $contact_person = $input['contact_person'];
    $contact_number = $input['contact_number'];
    $address = $input['address'];
    $supplier_type = $input['supplier_type'];
    $product_category_id = $input['product_category_id'];
    $payment_terms = $input['payment_terms'];
    $note = $input['note'];

    // Prepare the update SQL statement
    $stmt = $conn->prepare("
        UPDATE supplier
        SET supplier_name = ?, contact_person = ?, contact_number = ?, 
            address = ?, supplier_type = ?, product_category_id = ?,
            payment_terms = ?, note = ?
        WHERE supplier_id = ?
    ");

    if ($stmt === false) {
        throw new Exception('Query preparation failed: ' . $conn->error);
    }

    // Bind parameters to the SQL statement
    $stmt->bind_param(
        'ssississi',  // s: string, i: integer
        $supplier_name, $contact_person, $contact_number, 
        $address, $supplier_type, $product_category_id, 
        $payment_terms, $note, $supplier_id
    );

    // Execute the query and check if successful
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Database update failed: ' . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Close the statement and connection
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
