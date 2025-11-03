<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Product ID not provided."]);
    exit;
}

$productId = intval($_GET['id']);

$sql = "
    SELECT 
        p.id,
        p.product_name,
        p.barcode,
        p.brand_id,
        b.brand_name,
        p.category_id,
        c.category_name,
        p.subcategory_id,
        sc.subcategory_name,
        p.original_price,
        p.selling_price,
        p.quantity,
        p.reorder_point,
        p.status,
        p.supplier_id,
        s.supplier_name,
        p.description,
        p.date_created
    FROM products p
    LEFT JOIN brand b ON p.brand_id = b.brand_id
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN subcategory sc ON p.subcategory_id = sc.subcategory_id
    LEFT JOIN supplier s ON p.supplier_id = s.supplier_id
    WHERE p.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(["error" => "Product not found."]);
}

$stmt->close();
$conn->close();
?>
