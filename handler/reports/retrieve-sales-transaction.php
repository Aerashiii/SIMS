<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "simsdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Use correct table name (underscore, not dash)
$sql = "
    SELECT 
        s.transact_id,
        s.total_items,
        s.total_payment,
        s.payment_method,
        s.customer_name,
        s.contact_number,
        s.date,
        u.name AS user_name
    FROM sales_transaction AS s
    JOIN user AS u ON s.user_id = u.id
    ORDER BY s.date DESC
";

$result = $conn->query($sql);
$sales = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sales[] = $row;
    }
} else {
    $sales = [];
}

echo json_encode($sales);
$conn->close();
?>
