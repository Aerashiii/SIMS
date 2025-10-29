<?php
// retrieve-total-expenses.php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Connect to database
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Query: sum of original_price * quantity
$sql = "SELECT SUM(original_price * quantity) AS total_expenses 
        FROM products 
        WHERE deleted = 'no' OR deleted = ''";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'data' => [
            'total_expenses' => $row['total_expenses'] ?? 0
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Query failed'
    ]);
}

$conn->close();
?>
