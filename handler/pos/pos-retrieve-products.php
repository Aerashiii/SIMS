<?php
// Set headers
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection settings
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); // Ensure proper encoding

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Get and prepare search query
$searchQueryRaw = isset($_POST['query']) ? trim($_POST['query']) : '';
$searchQuery = "%$searchQueryRaw%";
$barcodeRaw = isset($_POST['barcode']) ? trim($_POST['barcode']) : '';

// Base SQL
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
            IFNULL(s.supplier_name, 'Unknown') AS supplier_name,
            p.description
        FROM products p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        LEFT JOIN subcategory sub ON p.subcategory_id = sub.subcategory_id
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id
        WHERE p.deleted = 'no'";

// Add filter if search query is provided
// Determine search type: barcode OR general query
if (!empty($barcodeRaw)) {
    $sql .= " AND p.barcode = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Prepare failed: ' . $conn->error
        ]);
        exit;
    }
    $stmt->bind_param("s", $barcodeRaw);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif (!empty($searchQueryRaw)) {
    $searchQuery = "%$searchQueryRaw%";
    $sql .= " AND (p.product_name LIKE ? OR p.barcode LIKE ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Prepare failed: ' . $conn->error
        ]);
        exit;
    }
    $stmt->bind_param("ss", $searchQuery, $searchQuery);
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
                'supplier' => $row['supplier_name'],
                'description' => $row['description']
            ];
        }

        $response['success'] = true;
        $response['data'] = $products;
    } else {
        $response['success'] = false;
        $response['message'] = 'No products found.';
    }
} else {
    http_response_code(500);
    $response['success'] = false;
    $response['message'] = 'Error executing query: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>
