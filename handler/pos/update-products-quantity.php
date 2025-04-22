<?php
//update-products-quantity.php
// This script updates the product quantities in the database based on the products sold in a transaction.
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$addedProducts = $data['addedProducts'];
$success = true;
foreach ($addedProducts as $product) {
    $productId = $product['id'];
    $quantitySold = $product['quantity'];

    // Update product quantity in the database for the specific branch
    $updateSql = "UPDATE products SET quantity = quantity - ? WHERE product_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $quantitySold, $productId);

    if (!$stmt->execute()) {
        $success = false;
        break;
    }
    $stmt->close();
}
// Send response based on success or failure
if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product quantities.']);
}
$conn->close();
