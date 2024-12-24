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

// Query to join category and subcategory tables
$sql = "
    SELECT 
        subcategory.subcategory_id, 
        subcategory.subcategory_name, 
        category.category_name, 
        subcategory.status, 
        subcategory.date_created
    FROM 
        subcategory
    INNER JOIN 
        category 
    ON 
        subcategory.category_id = category.category_id
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => "SQL prepare failed: " . $conn->error]));
}

if (!$stmt->execute()) {
    die(json_encode(['success' => false, 'message' => "Execution failed: " . $stmt->error]));
}

$result = $stmt->get_result();
$subcategory_data = $result->fetch_all(MYSQLI_ASSOC);

// Format date_created to "Month Day, Year" format
foreach ($subcategory_data as &$subcategory) {
    if (!empty($subcategory['date_created'])) {
        $subcategory['date_created'] = date("F j, Y", strtotime($subcategory['date_created']));
    }
}

unset($subcategory); // Break the reference to avoid side effects

echo json_encode($subcategory_data);

$stmt->close();
$conn->close();
?>
