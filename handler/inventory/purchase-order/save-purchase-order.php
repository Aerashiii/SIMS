<?php
session_start();
header('Content-Type: application/json');

// ✅ Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// ✅ Check user session
if (!isset($_SESSION['id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['id'];
$username = $_SESSION['user'];

// ✅ Decode JSON product list
$products = json_decode($_POST['products'], true);
if (!$products || !is_array($products)) {
    echo json_encode(["success" => false, "message" => "No products provided"]);
    exit;
}

// ✅ Compute totals
$total_cost = 0;
$total_product = count($products);
$supplier_id = $products[0]['supplier_id'] ?? 0;
$status = "pending"; // Always set to pending

foreach ($products as $p) {
    $total_cost += ($p['original_price'] * $p['quantity']);
}

// ✅ Insert into purchase_order_transaction
$stmt = $conn->prepare("
    INSERT INTO purchase_order_transaction (user_id, total_product, total_cost, supplier_id, status, deleted)
    VALUES (?, ?, ?, ?, ?, 'no')
");
$stmt->bind_param("iiids", $user_id, $total_product, $total_cost, $supplier_id, $status);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // ✅ Prepare statements for product and order item insert
    $insertProductStmt = $conn->prepare("
        INSERT INTO products 
        (product_name, barcode, brand_id, category_id, subcategory_id, original_price, selling_price, quantity, reorder_point, status, supplier_id, description, deleted)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'no')
    ");

    $insertOrderItemStmt = $conn->prepare("
        INSERT INTO ordered_products (order_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");

    foreach ($products as $p) {
        // Check if product already exists by barcode
        $barcode = $p['barcode'];
        $checkProduct = $conn->prepare("SELECT id FROM products WHERE barcode = ?");
        $checkProduct->bind_param("s", $barcode);
        $checkProduct->execute();
        $checkProduct->store_result();

        if ($checkProduct->num_rows > 0) {
            // ✅ Product exists → get product_id
            $checkProduct->bind_result($product_id);
            $checkProduct->fetch();
        } else {
            // ✅ Insert new product
            $product_name = $p['name'];
            $brand_id = $p['brand_id'] ?: null;
            $category_id = $p['category_id'] ?: null;
            $subcategory_id = $p['subcategory_id'] ?: null;
            $original_price = $p['original_price'];
            $selling_price = $p['selling_price'];
            $quantity = $p['quantity'];
            $reorder_point = $p['reorder_point'];
            $product_status = "pending";
            $supplier = $p['supplier_id'] ?: null;
            $description = $p['description'];

            $insertProductStmt->bind_param(
                "ssiiiiddisis",
                $product_name,
                $barcode,
                $brand_id,
                $category_id,
                $subcategory_id,
                $original_price,
                $selling_price,
                $quantity,
                $reorder_point,
                $product_status,
                $supplier,
                $description
            );

            $insertProductStmt->execute();
            $product_id = $insertProductStmt->insert_id;
        }

        // ✅ Link product to order
        $quantity_ordered = $p['quantity'];
        $insertOrderItemStmt->bind_param("iii", $order_id, $product_id, $quantity_ordered);
        $insertOrderItemStmt->execute();

        $checkProduct->close();
    }

    echo json_encode([
        "success" => true,
        "message" => "Purchase order saved successfully and set to pending.",
        "order_id" => $order_id,
        "user" => $username
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to insert purchase order transaction"]);
}

$conn->close();
?>
