<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$sql = "SELECT 
            p.id, 
            p.user_id, 
            p.total_product, 
            p.status, 
            p.date,
            u.name AS username
        FROM purchase_order_transaction AS p
        LEFT JOIN user AS u ON p.user_id = u.id
        WHERE p.deleted = 'no'";

if (!empty($search)) {
    $sql .= " AND p.id LIKE ?";
}

$sql .= " ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $likeSearch = "%$search%";
    $stmt->bind_param("s", $likeSearch);
}

$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

if (!empty($transactions)) {
    echo json_encode(['success' => true, 'data' => $transactions]);
} else {
    echo json_encode(['success' => false, 'message' => 'No transactions found', 'data' => []]);
}

$stmt->close();
$conn->close();
?>
