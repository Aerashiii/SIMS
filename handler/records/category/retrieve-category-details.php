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
    $categoryId = intval($_GET['id']); // Corrected variable name

    // Updated SQL query to fetch product and category details
    $sql = "
        SELECT * FROM category WHERE category_id =?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",  $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        echo json_encode( $category);
    } else {
        echo json_encode(['error' => 'Product not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Product ID not provided.']);
}

$conn->close();
?>
