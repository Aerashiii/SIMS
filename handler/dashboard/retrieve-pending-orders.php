<?php
// retrieve-pending-orders.php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// ✅ Connect to database
$conn = new mysqli($server, $username, $password, $dbname);

// ❌ Handle connection error
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

/*
    ✅ Logic:
    - Count all records from purchase_order_transaction
    - Only those with status = 0 (pending)
    - Exclude deleted = 'yes' (or include only deleted = 'no')
*/
$sql = "
    SELECT COUNT(*) AS total_pending_orders
    FROM purchase_order_transaction
    WHERE status = 'pending'
      AND (deleted = 'no' OR deleted = '')
";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'data' => [
            'total_pending_orders' => (int)($row['total_pending_orders'] ?? 0)
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve pending orders'
    ]);
}

$conn->close();
?>
