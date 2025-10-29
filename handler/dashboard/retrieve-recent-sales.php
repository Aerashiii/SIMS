<?php
// retrieve-recent-sales.php
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
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// ✅ Query: fetch recent sales (latest 10)
$sql = "
    SELECT 
        transact_id,
        customer_name,
        total_items,
        total_payment,
        date
    FROM sales_transaction
    WHERE 1
    ORDER BY date DESC, transact_id DESC
    LIMIT 10
";

$result = $conn->query($sql);

$recent_sales = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_sales[] = [
            'transact_id' => (int)$row['transact_id'],
            'customer_name' => $row['customer_name'],
            'total_items' => (int)$row['total_items'],
            'total_payment' => (int)$row['total_payment'],
            'date' => $row['date']
        ];
    }
}

echo json_encode([
    'success' => true,
    'data' => $recent_sales
]);

$conn->close();
?>
