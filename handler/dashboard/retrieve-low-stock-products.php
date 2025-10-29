<?php
header('Content-Type: application/json');

// ✅ Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

// ❌ Handle connection failure
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

$response = [
    'success' => true,
    'data' => [
        'low_stock_count' => 0
    ]
];

try {
    // ✅ Define your low stock threshold (example: below 10)
    $threshold = 10;

    // ✅ Query: count products with quantity below threshold
    $sql = "
        SELECT COUNT(*) AS low_stock_count 
        FROM products 
        WHERE quantity < $threshold 
          AND status = 'active' 
          AND deleted = 'no'
    ";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $response['data']['low_stock_count'] = (int)($row['low_stock_count'] ?? 0);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to fetch low-stock products.';
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
}

// ✅ Return JSON response
$conn->close();
echo json_encode($response);
?>
