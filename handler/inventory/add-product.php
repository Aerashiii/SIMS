<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name   = trim($_POST['product_name'] ?? '');
    $barcode        = trim($_POST['product_barcode'] ?? '');
    $brand_id       = ($_POST['product_brand'] !== "") ? (int) $_POST['product_brand'] : null;
    $category_id    = ($_POST['product_category'] !== "") ? (int) $_POST['product_category'] : null;
    $subcategory_id = ($_POST['product_subcategory'] !== "") ? (int) $_POST['product_subcategory'] : null;
    $original_price = ($_POST['original_price'] !== "") ? (float) $_POST['original_price'] : null;
    $selling_price  = ($_POST['selling_price'] !== "") ? (float) $_POST['selling_price'] : null;
    $quantity       = ($_POST['quantity'] !== "") ? (int) $_POST['quantity'] : null;
    $reorder_point  = ($_POST['reorder_point'] !== "") ? (int) $_POST['reorder_point'] : null;
    $status         = $_POST['status'] ?? "active";
    $supplier_id    = ($_POST['supplier_id'] !== "") ? (int) $_POST['supplier_id'] : null;
    $description    = trim($_POST['description'] ?? '');
    $deleted        = 'no';

    if (!$product_name || !$barcode) {
        echo json_encode(['success' => false, 'message' => 'Product name and barcode are required.']);
        exit;
    }

    $sql = "
        INSERT INTO products (
            product_name, barcode, brand_id, category_id, subcategory_id,
            original_price, selling_price, quantity, reorder_point, status,
            supplier_id, description, deleted
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    // 🔹 Use variables first
    $p_name  = $product_name;
    $p_bar   = $barcode;
    $p_brand = $brand_id;
    $p_cat   = $category_id;
    $p_sub   = $subcategory_id;
    $p_op    = $original_price;
    $p_sp    = $selling_price;
    $p_qty   = $quantity;
    $p_rp    = $reorder_point;
    $p_status= $status;
    $p_sup   = $supplier_id;
    $p_desc  = $description;
    $p_del   = $deleted;

    // 🔹 Bind with correct types (i=int, d=double, s=string, b=blob)
    $stmt->bind_param(
        "ssiiiddiiisss",
        $p_name,
        $p_bar,
        $p_brand,
        $p_cat,
        $p_sub,
        $p_op,
        $p_sp,
        $p_qty,
        $p_rp,
        $p_status,
        $p_sup,
        $p_desc,
        $p_del
    );

    // 🔹 Convert empty fields to NULL before execute
    if ($p_brand === null) $stmt->bind_param("i", $p_brand);
    if ($p_cat === null) $stmt->bind_param("i", $p_cat);
    if ($p_sub === null) $stmt->bind_param("i", $p_sub);
    if ($p_sup === null) $stmt->bind_param("i", $p_sup);

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
