<?php
// Database credentials
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Set response header to JSON
header('Content-Type: application/json');

// Connect to the database
$conn = new mysqli($server, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit();
}

// Sanitize and retrieve POST input
$searchQuery = isset($_POST['query']) ? trim($_POST['query']) : '';
$statusFilter = isset($_POST['status']) ? trim($_POST['status']) : '';

// Initialize base SQL query
$sql = "
    SELECT 
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
    WHERE 1 = 1
";

// Prepare dynamic conditions
$params = [];
$types = "";

// If search query exists, add filter
if (!empty($searchQuery)) {
    $sql .= " AND r.renter_name LIKE CONCAT('%', ?, '%')";
    $params[] = $searchQuery;
    $types .= "s";
}

// Define valid status values
$validStatuses = ['active', 'completed', 'pending', 'cancelled'];

// If valid status filter provided, add condition
if (!empty($statusFilter) && in_array(strtolower($statusFilter), $validStatuses)) {
    $sql .= " AND rt.status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

// Finalize query with grouping
$sql .= " GROUP BY rt.id";

// Prepare SQL statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'SQL preparation failed: ' . $conn->error
    ]);
    exit();
}

// Bind parameters if available
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Execute the query
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Query execution failed: ' . $stmt->error
    ]);
    exit();
}

// Get results
$result = $stmt->get_result();
if (!$result) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve results: ' . $stmt->error
    ]);
    exit();
}

// Build response data
$rentals = [];
while ($row = $result->fetch_assoc()) {
    $rentals[] = [
        'id' => (int)$row['id'],
        'renter_name' => $row['renter_name'],
        'quantity' => (int)$row['rented_quantity'],
        'payment' => (float)$row['payment'],
        'rental_start_date' => $row['rental_start_date'],
        'rental_end_date' => $row['rental_end_date'],
        'status' => $row['status'],
        'box_numbers' => $row['box_numbers'] ?? 'Not specified'
    ];
}

// Output final JSON
echo json_encode([
    'success' => true,
    'data' => $rentals
]);

// Close connections
$stmt->close();
$conn->close();
?>
