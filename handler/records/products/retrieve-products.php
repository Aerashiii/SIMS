<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the response header to return JSON
header('Content-Type: application/json');

// Initialize an empty response array
$response = array();

// SQL query to retrieve product data along with related category, subcategory, brand, and supplier information
$sql = "SELECT 
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
        WHERE p.status = 'active' AND p.deleted='no'";  // You can change this condition if necessary

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if query is successful
if ($result) {
    // If there are records, fetch the data
    if (mysqli_num_rows($result) > 0) {
        $products = array();

        while ($row = mysqli_fetch_assoc($result)) {
            // Add each product to the array with category, subcategory, and brand names
            $products[] = array(
                'id' => $row['id'],
                'product_name' => $row['product_name'],
                'barcode' => $row['barcode'],
                'brand_name' => $row['brand_name'],  
                'category_name' => $row['category_name'],  
                'subcategory_name' => $row['subcategory_name'], 
                'original_price' => $row['original_price'],
                'selling_price' => $row['selling_price'],
                'quantity' => $row['quantity'],
                'reorder_point' => $row['reorder_point'],
                'status' => $row['status'],
                'supplier' => $row['supplier_name']
            );
        }

        // Send the response with the product data
        $response['success'] = true;
        $response['data'] = $products;
    } else {
        // No products found
        $response['success'] = false;
        $response['message'] = 'No products found.';
    }
} else {
    // Query failed
    $response['success'] = false;
    $response['message'] = 'Error fetching products: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Return the response as JSON
echo json_encode($response);
?>
