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

// Set the response header
header('Content-Type: application/json');

// Get and sanitize search query
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';

// Base query
$sql = "SELECT renter_id, renter_name, contact_number FROM renter";
$params = [];
$types = "";

// If searching
if (!empty($searchQuery)) {
    $sql .= " WHERE renter_name LIKE ?";
    $params[] = "%" . $searchQuery . "%";
    $types .= "s";
}

// Prepare and execute query
if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// Build response
$response = [];

if ($result) {
    if ($result->num_rows > 0) {
        $renters = [];

        while ($row = $result->fetch_assoc()) {
            $renters[] = [
                'renter_id' => $row['renter_id'],
                'renter_name' => $row['renter_name'],
                'contact_number' => $row['contact_number']
            ];
        }

        $response['success'] = true;
        $response['data'] = $renters;
    } else {
        $response['success'] = false;
        $response['message'] = 'No renter found.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Error executing query: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>
