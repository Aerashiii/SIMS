<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Retrieve rental transactions with renter info
$sql = "
    SELECT 
        rt.id AS rental_transaction_id,
        r.renter_name,
        r.contact_number,
        rt.rented_quantity,
        rt.payment,
        rt.rental_start_date,
        rt.rental_end_date,
        rt.status,
        rt.date_created
    FROM rental_transaction rt
    JOIN renter r ON rt.renter_id = r.renter_id
    WHERE rt.deleted = 'no'
    ORDER BY rt.date_created DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Query failed: " . $conn->error]);
    exit;
}

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

echo json_encode(["success" => true, "data" => $transactions]);
$conn->close();
?>
