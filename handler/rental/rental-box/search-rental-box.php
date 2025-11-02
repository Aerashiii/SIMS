<?php
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$search = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM rental_box WHERE box_number LIKE ? OR box_size LIKE ? ORDER BY box_id DESC");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM rental_box ORDER BY box_id DESC");
}

$boxes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $boxes[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $boxes]);
$conn->close();
?>
