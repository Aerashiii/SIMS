<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => $conn->connect_error]);
    exit();
}

// Fetch sales from the last 1 day
$sql = "SELECT date, customer_name, total_items, total_payment 
        FROM `sales-transaction` 
        WHERE date >= NOW() - INTERVAL 1 DAY 
        ORDER BY date DESC 
        LIMIT 10";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['date'],
            'customer_name' => $row['customer_name'],
            'total_items' => $row['total_items'],
            'total_payment' => $row['total_payment']
        ];
    }
}

$conn->close();

echo json_encode([
    'success' => true,
    'data' => $data
]);
?>
