<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

header('Content-Type: application/json');

// SQL query to fetch supplier details with category and payment type
$sql = "
    SELECT 
        s.supplier_id,
        s.supplier_name,
        s.contact_person,
        s.contact_number,
        s.address,
        s.supplier_type,
        c.category_name AS product_category_name,
        p.payment_type AS payment_type,
        s.note
    FROM 
        supplier AS s
    LEFT JOIN 
        category AS c 
    ON 
        s.product_category_id = c.category_id
    LEFT JOIN 
        payment AS p
    ON 
        s.payment_terms = p.payment_id
    WHERE s.deleted = 'no'
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Query failed: " . $conn->error]);
    exit();
}

$supplier_data = [];
while ($row = $result->fetch_assoc()) {
    $supplier_data[] = $row;
}

// Output JSON response
echo json_encode([
    "success" => true,
    "data" => $supplier_data
], JSON_PRETTY_PRINT);

$conn->close();
?>
