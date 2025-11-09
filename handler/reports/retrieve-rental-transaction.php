<?php
header('Content-Type: application/json');


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "simsdb";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$sql = "
    SELECT 
        rt.id AS rental_id,
        r.renter_name,
        rt.rented_quantity,
        rt.payment,
        rt.rental_start_date,
        rt.rental_end_date,
        rt.status
    FROM rental_transaction rt
    INNER JOIN renter r ON r.renter_id = rt.renter_id
    WHERE rt.deleted = 'no'
    ORDER BY rt.date_created DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

$reports = [];
while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

echo json_encode($reports);
$conn->close();
?>
