<?php
// Include database connection
require_once '../config/db.php'; // Adjust the path if necessary

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $product_name = isset($_POST['add-product-name']) ? mysqli_real_escape_string($conn, $_POST['add-product-name']) : '';
    $barcode = isset($_POST['add-product-barcode']) ? mysqli_real_escape_string($conn, $_POST['add-product-barcode']) : '';
    $brand_id = isset($_POST['add-product-brand']) ? (int) $_POST['add-product-brand'] : 0;
    $category_id = isset($_POST['add-product-category']) ? (int) $_POST['add-product-category'] : 0;
    $subcategory_id = isset($_POST['add-product-subcategory']) ? (int) $_POST['add-product-subcategory'] : 0;
    $original_price = isset($_POST['add-product-original-price']) ? (float) $_POST['add-product-original-price'] : 0;
    $selling_price = isset($_POST['add-product-selling-price']) ? (float) $_POST['add-product-selling-price'] : 0;
    $quantity = isset($_POST['add-product-quantity']) ? (int) $_POST['add-product-quantity'] : 0;
    $reorder_point = isset($_POST['add-product-reorder-point']) ? (int) $_POST['add-product-reorder-point'] : 0;
    $status = isset($_POST['add-product-status']) ? mysqli_real_escape_string($conn, $_POST['add-product-status']) : '';
    $supplier_id = isset($_POST['add-product-supplier']) ? (int) $_POST['add-product-supplier'] : 0;

    // Validate required fields
    if (empty($product_name) || empty($barcode) || empty($brand_id) || empty($category_id) || empty($subcategory_id) || empty($original_price) || empty($selling_price) || empty($quantity) || empty($reorder_point) || empty($status) || empty($supplier_id)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // SQL to insert product data into the products table
    $sql = "INSERT INTO products (product_name, barcode, brand_id, category_id, subcategory_id, original_price, selling_price, quantity, reorder_point, status, supplier_id)
            VALUES ('$product_name', '$barcode', $brand_id, $category_id, $subcategory_id, $original_price, $selling_price, $quantity, $reorder_point, '$status', $supplier_id)";

    // Execute the query and check for errors
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
