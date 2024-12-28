<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response header to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the Product ID from POST data
    $productId = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Check if the product ID is valid
    if ($productId) {
        // Prepare SQL to delete the product
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared correctly
        if ($stmt) {
            $stmt->bind_param("i", $productId);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Product deleted successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to delete product.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error preparing statement.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid Product ID.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}

?>

