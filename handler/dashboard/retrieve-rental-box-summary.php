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

// Fetch rental box summary
$sql = "
    SELECT 
        rentalbox.box_number,
        renter.renter_name,
        `rental-transaction`.status,
        `rental-transaction`.rental_start_date AS date_rented
    FROM `rented-box-transaction`
    INNER JOIN rentalbox ON rentalbox.box_id = `rented-box-transaction`.box_id
    INNER JOIN `rental-transaction` ON `rental-transaction`.id = `rented-box-transaction`.rental_transaction_id
    INNER JOIN renter ON renter.renter_id = `rented-box-transaction`.renter_id
    ORDER BY `rental-transaction`.rental_start_date DESC
";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'box_number' => $row['box_number'],
            'renter_name' => $row['renter_name'] ?? 'Unknown',
            'status' => $row['status'],
            'date' => $row['date_rented'] // Changed from 'date' to 'date_rented'
        ];
    }
}

$conn->close();

echo json_encode([
    'success' => true,
    'data' => $data
]);
?>