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


$sql = "SELECT category_id, category_name, status,date_created FROM category WHERE deleted='no'";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => "SQL prepare failed: " . $conn->error]));
}


if (!$stmt->execute()) {
    die(json_encode(['success' => false, 'message' => "Execution failed: " . $stmt->error]));
}

$result = $stmt->get_result();
$category_data = $result->fetch_all(MYSQLI_ASSOC);

// Format created_date to "Month Day, Year" format
foreach ($category_data as &$category) {
    if (!empty($category['date_created'])) {
        $category['date_created'] = date("F j, Y", strtotime($category['date_created']));
    }
}

unset($category); // Break the reference to avoid side effects

echo json_encode($category_data);

$stmt->close();
$conn->close();
?>
