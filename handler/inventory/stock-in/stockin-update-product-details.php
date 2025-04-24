<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Set the response header to return JSON
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIds = $_POST['product_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];

    if (count($productIds) !== count($quantities)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Product ID and quantity count mismatch.']);
        exit;
    }

    $successCount = 0;

    for ($i = 0; $i < count($productIds); $i++) {
        $productId = intval($productIds[$i]);
        $stockInQuantity = intval($quantities[$i]);

        // Fetch current quantity
        $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $newQuantity = $row['quantity'] + $stockInQuantity;

            // Update quantity
            $updateStmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
            $updateStmt->bind_param("ii", $newQuantity, $productId);

            if ($updateStmt->execute()) {
                $successCount++;
            }
        }

        $stmt->close();
    }

    $conn->close();

    echo json_encode([
        'success' => true,
        'message' => "$successCount product(s) updated successfully."
    ]);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
