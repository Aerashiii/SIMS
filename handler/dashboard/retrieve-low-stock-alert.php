<?php
// retrieve-low-stock-alert.php
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
    - Retrieve all active products that are NOT deleted
    - And quantity <= reorder_point
    - Show: product_name, quantity, reorder_point, and alert message
*/
$sql = "
    SELECT 
        id,
        product_name,
        quantity,
        reorder_point,
        CASE
            WHEN quantity = 0 THEN 'Out of Stock'
            WHEN quantity <= reorder_point THEN 'Low Stock'
            ELSE 'Normal'
        END AS alert_status
    FROM products
    WHERE status = 'active'
      AND deleted = 'no'
      AND quantity <= reorder_point
    ORDER BY quantity ASC
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $low_stock_items = [];

    while ($row = $result->fetch_assoc()) {
        $low_stock_items[] = [
            'product_name' => $row['product_name'],
            'quantity' => (int)$row['quantity'],
            'alert_status' => $row['alert_status']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $low_stock_items
    ]);
} else {
    echo json_encode([
        'success' => true,
        'data' => [] // Empty list
    ]);
}

$conn->close();
?>
