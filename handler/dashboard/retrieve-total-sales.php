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
        'total_sales' => 0
    ]
];

try {
    // ✅ Option 1: Sum total_payment from sales_transaction table
    $sql = "SELECT SUM(total_payment) AS total_sales FROM sales_transaction";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $response['data']['total_sales'] = (int)($row['total_sales'] ?? 0);
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to fetch total sales.';
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
}

// ✅ Close connection and output JSON
$conn->close();
echo json_encode($response);
?>
