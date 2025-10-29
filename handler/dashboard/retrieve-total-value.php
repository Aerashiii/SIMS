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
        'total_value' => 0
    ]
];

try {
    // ✅ Query: total inventory value (sum of all product stock * selling price)
    $sql = "
        SELECT SUM(quantity * selling_price) AS total_value 
        FROM products 
        WHERE status = 'active' AND deleted = 'no'
    ";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $response['data']['total_value'] = (int)($row['total_value'] ?? 0);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to fetch total value.';
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
}

// ✅ Return JSON
$conn->close();
echo json_encode($response);
?>
