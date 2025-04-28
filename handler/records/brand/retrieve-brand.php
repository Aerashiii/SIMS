<?php


$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');


$sql = "SELECT brand_id, brand_name, status,date_created FROM brand WHERE deleted='no'";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => "SQL prepare failed: " . $conn->error]));
}


if (!$stmt->execute()) {
    die(json_encode(['success' => false, 'message' => "Execution failed: " . $stmt->error]));
}

$result = $stmt->get_result();
$brand_data = $result->fetch_all(MYSQLI_ASSOC);

// Format created_date to "Month Day, Year" format
foreach ($brand_data as &$brand) {
    if (!empty($brand['date_created'])) {
        $brand['date_created'] = date("F j, Y", strtotime($brand['date_created']));
    }
}

unset($brand); // Break the reference to avoid side effects

echo json_encode($brand_data);

$stmt->close();
$conn->close();
?>
