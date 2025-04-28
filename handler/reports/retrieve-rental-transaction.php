<?php
// fetch_rental_reports.php

// Connect to database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'simsdb'; // << CHANGE THIS

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the rental transactions with needed info
$sql = "
    SELECT 
        rt.id AS rental_id,
        r.renter_name,
        CONCAT('Box ', b.box_number, ' (', b.box_size, ' - ', b.width, 'x', b.length, ')') AS item_rented,
        rbt.quantity,
        b.rental_fee,
        rt.rental_start_date,
        rt.rental_end_date,
        rt.status
    FROM `rental-transaction` rt
    JOIN `renter` r ON r.renter_id = rt.renter_id
    JOIN `rented-box-transaction` rbt ON rbt.rental_transaction_id = rt.id
    JOIN `rentalbox` b ON b.box_id = rbt.box_id
";

$result = $conn->query($sql);

$reports = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($reports);
