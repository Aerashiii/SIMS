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

// Set the response header to return JSON
header('Content-Type: application/json');

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Base SQL query for products with 0 quantity
$sql = "SELECT 
            p.id,
            p.product_name,
            p.barcode,
            IFNULL(b.brand_name, 'Unknown') AS brand_name,
            IFNULL(c.category_name, 'Unknown') AS category_name,
            IFNULL(sub.subcategory_name, 'Unknown') AS subcategory_name,
            p.original_price,
            p.selling_price,
            p.quantity,
            p.reorder_point,
            p.status,
            IFNULL(s.supplier_name, 'Unknown') AS supplier_name
        FROM products p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        LEFT JOIN subcategory sub ON p.subcategory_id = sub.subcategory_id
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id
        WHERE p.status = 'active' AND p.quantity = 0";

// Add category filter if provided
if ($category_id) {
    $sql .= " AND p.category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$response = [];

if ($result) {
    if ($result->num_rows > 0) {
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'id' => $row['id'],
                'product_name' => $row['product_name'],
                'barcode' => $row['barcode'],
                'brand_name' => $row['brand_name'],
                'category_name' => $row['category_name'],
                'subcategory_name' => $row['subcategory_name'],
                'original_price' => $row['original_price'],
                'selling_price' => $row['selling_price'],
                'quantity' => $row['quantity'],
                'reorder_point' => $row['reorder_point'],
                'status' => $row['status'],
                'supplier' => $row['supplier_name']
            ];
        }

        $response['success'] = true;
        $response['data'] = $products;
    } else {
        $response['success'] = false;
        $response['message'] = 'No out-of-stock products found.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Error fetching products: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>
