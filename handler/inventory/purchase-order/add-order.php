<?php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
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
    if (empty($product_name) || empty($barcode) || $brand_id <= 0 || $category_id <= 0 || 
        $subcategory_id <= 0 || $original_price <= 0 || $selling_price <= 0 || 
        $quantity < 0 || $reorder_point < 0 || empty($status) || $supplier_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required and must have valid values.']);
        exit;
    }

    // Validate barcode length
    if (strlen($barcode) !== 13) {
        echo json_encode(['success' => false, 'message' => 'Barcode must be exactly 13 digits.']);
        exit;
    }

    // Check if the barcode already exists
    $check_query = "SELECT id FROM products WHERE barcode = '$barcode'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Barcode already exists. Please generate a new one.']);
        exit;
    }

    // SQL to insert product data into the purchase_order table (removed hyphen)
    $sql = "INSERT INTO `purchase-order` (product_name, barcode, brand_id, category_id, subcategory_id, 
            original_price, selling_price, quantity, reorder_point, status, supplier_id, deleted)
            VALUES ('$product_name', '$barcode', $brand_id, $category_id, $subcategory_id, 
            $original_price, $selling_price, $quantity, $reorder_point, '$status', $supplier_id, '$deleted')";

    // Execute the query and check for errors
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Purchase order added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>