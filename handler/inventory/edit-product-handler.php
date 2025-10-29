<?php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$database = "simsdb";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
    exit;
}

// Extract & sanitize
$id = (int) $data['product_id'];
$product_name = $conn->real_escape_string($data['product_name']);
$barcode = $conn->real_escape_string($data['barcode']);
$brand_id = (int) $data['brand_id'];
$category_id = (int) $data['category_id'];
$subcategory_id = (int) $data['subcategory_id'];
$supplier_id = (int) $data['supplier_id'];
$original_price = (float) $data['original_price'];
$selling_price = (float) $data['selling_price'];
$quantity = (int) $data['quantity'];
$reorder_point = (int) $data['reorder_point'];
$status = $conn->real_escape_string($data['status']);
$description = isset($data['description']) ? $conn->real_escape_string($data['description']) : '';

// Update SQL
$query = "
    UPDATE products 
    SET 
        product_name = '$product_name',
        barcode = '$barcode',
        brand_id = $brand_id,
        category_id = $category_id,
        subcategory_id = $subcategory_id,
        supplier_id = $supplier_id,
        original_price = $original_price,
        selling_price = $selling_price,
        quantity = $quantity,
        reorder_point = $reorder_point,
        status = '$status',
        description = '$description'
    WHERE id = $id
";

if ($conn->query($query)) {
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating product: " . $conn->error]);
}

$conn->close();
?>
