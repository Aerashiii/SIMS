<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit();
}

// Set response header
header('Content-Type: application/json');

// Get and sanitize input
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';
$statusFilter = isset($_POST['status']) ? trim($_POST['status']) : '';

// Base SQL - Updated to match your actual database schema
$sql = "SELECT 
            rt.id,
            IFNULL(r.renter_name, 'Unknown') AS renter_name,
            rt.rented_quantity,
            rt.payment,
            rt.rental_start_date,
            rt.rental_end_date,
            rt.status,
            GROUP_CONCAT(DISTINCT rb.box_number SEPARATOR ', ') AS box_numbers
        FROM `rental-transaction` rt
        LEFT JOIN renter r ON r.renter_id = rt.renter_id
        LEFT JOIN `rented-box-transaction` rbt ON rbt.rental_transaction_id = rt.id
        LEFT JOIN `rental-box` rb ON rb.box_id = rbt.box_id
        WHERE 1=1 ";

$params = [];
$types = "";

// Add conditions if searchQuery or statusFilter are provided
if (!empty($searchQuery)) {
    $sql .= " AND r.renter_name LIKE CONCAT('%', ?, '%') ";
    $params[] = $searchQuery;
    $types .= "s";
}

// Validate status against possible values
$validStatuses = ['active', 'completed', 'pending', 'cancelled'];
if (!empty($statusFilter) && in_array($statusFilter, $validStatuses)) {
    $sql .= " AND rt.status = ? ";
    $params[] = $statusFilter;
    $types .= "s";
}

// Add GROUP BY since we're using GROUP_CONCAT
$sql .= " GROUP BY rt.id ";

// Prepare and execute
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode([
        'success' => false,
        'message' => 'SQL Error: ' . $conn->error
    ]);
    exit();
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Execution failed: ' . $stmt->error
    ]);
    exit();
}

$result = $stmt->get_result();

if ($result === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Result retrieval failed: ' . $stmt->error
    ]);
    exit();
}

// Fetch data
$response = [];
$rentals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rentals[] = [
            'id' => (int)$row['id'],
            'renter_name' => $row['renter_name'],
            'quantity' => (int)$row['rented_quantity'],
            'payment' => (float)$row['payment'],
            'rental_start_date' => $row['rental_start_date'],
            'rental_end_date' => $row['rental_end_date'],
            'status' => $row['status'],
            'box_numbers' => $row['box_numbers'] ? $row['box_numbers'] : 'Not specified'
        ];
    }
}

$response['success'] = true;
$response['data'] = $rentals;

// Close connection
$stmt->close();
$conn->close();

// Output JSON
echo json_encode($response);
?>