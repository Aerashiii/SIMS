<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Ensure POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $product_name = trim($_POST['product_name'] ?? '');
    $barcode = trim($_POST['product_barcode'] ?? '');
    $brand_id = (int) ($_POST['product_brand'] ?? 0);
    $category_id = (int) ($_POST['product_category'] ?? 0);
    $subcategory_id = (int) ($_POST['product_subcategory'] ?? 0);
    $original_price = floatval($_POST['original_price'] ?? 0);
    $selling_price = floatval($_POST['selling_price'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $reorder_point = (int) ($_POST['reorder_point'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $supplier_id = (int) ($_POST['supplier_id'] ?? 0);
    $deleted = 'no';

    // Validate required
    if (
        !$product_name || !$barcode || !$brand_id || !$category_id || !$subcategory_id ||
        !$original_price || !$selling_price || !$quantity || !$reorder_point || !$status || !$supplier_id
    ) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO products (product_name, barcode, brand_id, category_id, subcategory_id, original_price, selling_price, quantity, reorder_point, status, supplier_id, deleted)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "ssiiiddiisss",
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
        $deleted
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
