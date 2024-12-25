<?php
// product-delete-handler.php
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
    // Get the Brand ID from POST data
   $brandId = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Check if the Brand ID is valid
    if ( $brandId) {
        // Prepare SQL to delete the brand
        $sql = "DELETE FROM brand WHERE brand_id = ?";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared correctly
        if ($stmt) {
            $stmt->bind_param("i",  $brandId);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Brand deleted successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to delete Brand.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error preparing statement.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid productbrand ID.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>

