<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

if (isset($_GET['id'])) {
    $subcategoryId = intval($_GET['id']); // Corrected variable name

    // Updated SQL query to fetch product and category details
    $sql = "
     SELECT 
        *
    FROM 
        subcategory
    INNER JOIN 
        category 
    ON 
        subcategory.category_id = category.category_id
    WHERE subcategory_id =?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",  $subcategoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $subcategory = $result->fetch_assoc();
        echo json_encode( $subcategory);
    } else {
        echo json_encode(['error' => 'Product not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Product ID not provided.']);
}

$conn->close();
?>
