<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Set the response header to return JSON
header('Content-Type: application/json');

// Sanitize input values
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';

// Initialize base SQL and params
$sql = "SELECT 
            r.box_id,
            r.box_number,
            r.box_size,
            r.width,
            r.length,
            r.rental_fee,
            r.quantity, 
            r.status         
        FROM rentalbox r      
        WHERE r.status = 'active'";

$params = [];
$types = "";

// Add search query condition if present
if (!empty($searchQuery)) {
    $sql .= " AND r.box_number LIKE ?";
    $searchWildcard = "%" . $searchQuery . "%";
    $params[] = $searchWildcard;
    $types .= "s";
}

// Prepare and execute
if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$response = [];

if ($result) {
    if ($result->num_rows > 0) {
        $boxes = [];

        while ($row = $result->fetch_assoc()) {
            $boxes[] = [
                'box_id' => $row['box_id'],
                'box_number' => $row['box_number'],
                'box_size' => $row['box_size'],
                'width' => $row['width'],
                'length' => $row['length'],
                'rental_fee' => $row['rental_fee'],
                'quantity' => $row['quantity'],
                'status' => $row['status']
            ];
        }

        $response['success'] = true;
        $response['data'] = $boxes;
    } else {
        $response['success'] = false;
        $response['message'] = 'No boxes found.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Error executing query: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>
