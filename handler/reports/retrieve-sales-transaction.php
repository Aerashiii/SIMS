<?php
// fetch_sales_transactions.php

// Connect to database
$servername = "localhost"; // or your server
$username = "root";        // your database username
$password = "";            // your database password
$database = "simsdb"; // your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch sales transactions
$sql = "SELECT * FROM `sales-transaction` ORDER BY `date` DESC";
$result = $conn->query($sql);

$sales = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sales[] = $row;
    }
}

echo json_encode($sales);

$conn->close();
?>
