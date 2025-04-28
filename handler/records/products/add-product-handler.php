<?php
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
$deleted = 'no';
// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $product_name = isset($_POST['product_name']) ? mysqli_real_escape_string($conn, $_POST['product_name']) : '';
    $barcode = isset($_POST['product_barcode']) ? mysqli_real_escape_string($conn, $_POST['product_barcode']) : '';
    $brand_id = isset($_POST['product_brand']) ? (int) $_POST['product_brand'] : 0;
    $category_id = isset($_POST['product_category']) ? (int) $_POST['product_category'] : 0;
    $subcategory_id = isset($_POST['product_subcategory']) ? (int) $_POST['product_subcategory'] : 0;
    $original_price = isset($_POST['original_price']) ? (float) $_POST['original_price'] : 0;
    $selling_price = isset($_POST['selling_price']) ? (float) $_POST['selling_price'] : 0;
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
    $reorder_point = isset($_POST['reorder_point']) ? (int) $_POST['reorder_point'] : 0;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
    $supplier_id = isset($_POST['supplier_id']) ? (int) $_POST['supplier_id'] : 0;

    // Validate required fields
    if (empty($product_name) || empty($barcode) || empty($brand_id) || empty($category_id) || empty($subcategory_id) || empty($original_price) || empty($selling_price) || empty($quantity) || empty($reorder_point) || empty($status) || empty($supplier_id)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // SQL to insert product data into the products table
    $sql = "INSERT INTO products (product_name, barcode, brand_id, category_id, subcategory_id, original_price, selling_price, quantity, reorder_point, status, supplier_id, deleted)
            VALUES ('$product_name', '$barcode', $brand_id, $category_id, $subcategory_id, $original_price, $selling_price, $quantity, $reorder_point, '$status', $supplier_id, $deleted)";

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
