<?php
header('Content-Type: application/json');
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// ✅ Connect to database
$conn = new mysqli($server, $username, $password, $dbname);

try {
    $query = "
        SELECT 
            r.renter_name AS renter,
            COUNT(rbt.box_id) AS total_boxes,
            rt.status,
            DATE_FORMAT(rt.date_created, '%Y-%m-%d %H:%i:%s') AS date
        FROM rented_box_transaction rbt
        JOIN renter r ON rbt.renter_id = r.renter_id
        JOIN rental_transaction rt ON rbt.rental_transaction_id = rt.id
        GROUP BY rbt.renter_id, rt.status, rt.date_created
        ORDER BY rt.date_created DESC
        LIMIT 10
    ";

    $result = $conn->query($query);
    $data = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode(['success' => true, 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
