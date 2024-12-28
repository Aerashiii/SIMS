<?php
// Database connection using MySQLi
$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Set response header to JSON
header('Content-Type: application/json');

// Get the POST data (assumed to be in JSON format)
$data = json_decode(file_get_contents("php://input"), true);

// Check if all required fields are provided
if (!isset($data['product_id']) || !isset($data['product_name']) || !isset($data['barcode']) || 
    !isset($data['category_id']) || !isset($data['subcategory_id']) || !isset($data['brand_id']) || 
    !isset($data['supplier_id']) || !isset($data['original_price']) || !isset($data['selling_price']) || 
    !isset($data['quantity']) || !isset($data['reorder_point']) || !isset($data['status'])) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Sanitize and assign the incoming data
$productId = (int) $data['product_id'];
$productName = $conn->real_escape_string($data['product_name']);
$barcode = $conn->real_escape_string($data['barcode']);
$categoryId = (int) $data['category_id'];
$subcategoryId = (int) $data['subcategory_id'];
$brandId = (int) $data['brand_id'];
$supplierId = (int) $data['supplier_id'];
$originalPrice = (float) $data['original_price'];
$sellingPrice = (float) $data['selling_price'];
$quantity = (int) $data['quantity'];
$reorderPoint = (int) $data['reorder_point'];
$status = $conn->real_escape_string($data['status']);

// SQL query to update product details
$query = "
    UPDATE products 
    SET product_name = '$productName', 
        barcode = '$barcode', 
        category_id = '$categoryId', 
        subcategory_id = '$subcategoryId', 
        brand_id = '$brandId', 
        supplier_id = '$supplierId', 
        original_price = '$originalPrice', 
        selling_price = '$sellingPrice', 
        quantity = '$quantity', 
        reorder_point = '$reorderPoint', 
        status = '$status' 
    WHERE id = $productId
";

// Execute the query and check for errors
if ($conn->query($query) === TRUE) {
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating product: " . $conn->error]);
}

// Close the connection
$conn->close();
?>
