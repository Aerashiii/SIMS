<?php 
// Set header FIRST before any output
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed']);
    exit;
}

$deleted = 'no';

// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the request
    $categoryId = $_POST['category_id'] ?? null;
    $subcategory_name = $_POST['subcategory_name'] ?? null;
    $subcategory_status = $_POST['subcategory_status'] ?? null;

    // Validate input
    if (!$categoryId || !$subcategory_name || !$subcategory_status) {
        echo json_encode(['success' => false, 'message' => 'Missing fields']);
        exit;
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO subcategory (subcategory_name, category_id, status, deleted) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $subcategory_name, $categoryId, $subcategory_status, $deleted);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Subcategory added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>