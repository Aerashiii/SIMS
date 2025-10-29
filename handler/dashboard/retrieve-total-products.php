<?php
header('Content-Type: application/json');

// ✅ Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

// ❌ If connection fails
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
        'total_products' => 0
    ]
];

try {
    // ✅ Count total number of active and non-deleted products
    $sql = "SELECT COUNT(*) AS total_products FROM products WHERE status = 'active' AND deleted = 'no'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $response['data']['total_products'] = (int)($row['total_products'] ?? 0);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to fetch product count.';
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
}

// ✅ Output JSON response
$conn->close();
echo json_encode($response);
?>
