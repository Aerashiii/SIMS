<?php
// Database connection using MySQLi
$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Set response header to JSON
header('Content-Type: application/json');

// Get product ID from the request
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if the product ID is valid
if ($productId <= 0) {
    echo json_encode(["error" => "Invalid product ID"]);
    exit;
}

// SQL query to retrieve product details and related information
$query = "  SELECT 
            p.id,
            p.product_name,
            p.barcode,
            IFNULL(b.brand_name, 'Unknown') AS brand_name,  -- Handling NULL values
            IFNULL(c.category_name, 'Unknown') AS category_name,  -- Handling NULL values
            IFNULL(sub.subcategory_name, 'Unknown') AS subcategory_name,  -- Handling NULL values
            p.original_price,
            p.selling_price,
            p.quantity,
            p.reorder_point,
            p.status,
            s.supplier_name
        FROM products p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        LEFT JOIN subcategory sub ON p.subcategory_id = sub.subcategory_id
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id
   
    WHERE p.id = $productId
";

// Execute the query
$result = $conn->query($query);

// Check if the product was found
if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
    // Return the product details as JSON
    echo json_encode($product);
} else {
    echo json_encode(["error" => "Product not found"]);
}

// Close the connection
$conn->close();
?>
