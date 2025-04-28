<?php
// Database credentials
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Set the response header to return JSON early
header('Content-Type: application/json');

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit(); // Always exit after sending a response
}

// Sanitize input values
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';
$categoryId = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';

// Initialize base SQL and parameters
$sql = "SELECT 
            p.order_id,
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
        FROM `purchase-order` p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        LEFT JOIN subcategory sub ON p.subcategory_id = sub.subcategory_id
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id
        WHERE p.status = 'pending' OR p.status = 'completed' AND p.deleted = 'no'" ;

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

    // Check if prepare() failed
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Prepare failed: ' . $conn->error
        ]);
        exit();
    }

    // Bind parameters dynamically
    $stmt->bind_param($types, ...$params);

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// Initialize response
$response = [];

if ($result) {
    if ($result->num_rows > 0) {
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'order_id' => $row['order_id'],
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

// Close connection
$conn->close();

// Output JSON
echo json_encode($response);
?>
