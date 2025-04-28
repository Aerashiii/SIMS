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

// Fetch products with low stock
$sql = "SELECT product_name, quantity, reorder_point 
        FROM products 
        WHERE quantity <= reorder_point 
        ORDER BY quantity ASC";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'product_name' => $row['product_name'],
            'current_stock' => $row['quantity'],
            'reorder_point' => $row['reorder_point']
        ];
    }
}

$conn->close();

echo json_encode([
    'success' => true,
    'data' => $data
]);
?>
