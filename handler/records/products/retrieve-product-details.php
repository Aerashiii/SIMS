<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); 

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Query preparation failed.']);
        exit;
    }

    $stmt->bind_param("i",  $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);  // Return the entire product details
    } else {
        echo json_encode(['error' => 'Product not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Product ID not provided.']);
}

$conn->close();
?>
