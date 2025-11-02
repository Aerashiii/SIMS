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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit;
}

// Get rental + renter details
$sql = "
    SELECT 
        rt.id AS rental_transaction_id,
        r.renter_name,
        r.contact_number,
        rt.rental_start_date,
        rt.rental_end_date,
        rt.status
    FROM rental_transaction rt
    JOIN renter r ON rt.renter_id = r.renter_id
    WHERE rt.id = $id
";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $rental = $result->fetch_assoc();

    // Fetch rented boxes
    $boxSql = "
        SELECT 
            rb.box_number,
            rb.box_size,
            rbt.quantity,
            (rb.rental_fee * rbt.quantity) AS total_fee
        FROM rented_box_transaction rbt
        JOIN rental_box rb ON rbt.box_id = rb.box_id
        WHERE rbt.rental_transaction_id = $id
    ";

    $boxResult = $conn->query($boxSql);
    $boxes = [];
    while ($box = $boxResult->fetch_assoc()) {
        $boxes[] = $box;
    }

    $rental['boxes'] = $boxes;
    echo json_encode(["success" => true, "data" => $rental]);
} else {
    echo json_encode(["success" => false, "message" => "Rental not found"]);
}

$conn->close();
?>
