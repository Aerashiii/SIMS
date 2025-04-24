<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Set the response header to return JSON
header('Content-Type: application/json');

// Sanitize input values
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';
$categoryId = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';

// Initialize base SQL and params
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
        WHERE p.status = 'active' AND p.quantity <= p.reorder_point
        AND p.reorder_point > 0";

$params = [];
$types = "";

// Apply filters
if (!empty($categoryId)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $categoryId;
    $types .= "i";
}

if (!empty($searchQuery)) {
    $sql .= " AND (p.product_name LIKE ? OR p.barcode LIKE ?)";
    $searchWildcard = "%" . $searchQuery . "%";
    $params[] = $searchWildcard;
    $params[] = $searchWildcard;
    $types .= "ss";
}

// Prepare and execute
if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
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
        $response['message'] = 'No products found.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Error executing query: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>

