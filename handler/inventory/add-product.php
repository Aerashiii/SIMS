<?php
header('Content-Type: application/json');
error_reporting(0);

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name   = trim($_POST['product_name'] ?? '');
    $barcode        = trim($_POST['product_barcode'] ?? '');
    $brand_id       = $_POST['product_brand'] !== "" ? (int) $_POST['product_brand'] : null;
    $category_id    = $_POST['product_category'] !== "" ? (int) $_POST['product_category'] : null;
    $subcategory_id = $_POST['product_subcategory'] !== "" ? (int) $_POST['product_subcategory'] : null;
    $original_price = (float) ($_POST['original_price'] ?? 0);
    $selling_price  = (float) ($_POST['selling_price'] ?? 0);
    $quantity       = (int) ($_POST['quantity'] ?? 0);
    $reorder_point  = (int) ($_POST['reorder_point'] ?? 0);
    $status         = $_POST['status'] ?? "active";
    $supplier_id    = $_POST['supplier_id'] !== "" ? (int) $_POST['supplier_id'] : null;
    $description    = trim($_POST['description'] ?? '');
    $deleted        = 'no';

    if (!$product_name || !$barcode) {
        echo json_encode(['success' => false, 'message' => 'Product name and barcode are required.']);
        exit;
    }

    $sql = "INSERT INTO products 
        (product_name, barcode, brand_id, category_id, subcategory_id, original_price, selling_price, quantity, reorder_point, status, supplier_id, description, deleted)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssiiiddiisiss",
        $product_name,
        $barcode,
        $brand_id,
        $category_id,
        $subcategory_id,
        $original_price,
        $selling_price,
        $quantity,
        $reorder_point,
        $status,
        $supplier_id,
        $description,
        $deleted
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
