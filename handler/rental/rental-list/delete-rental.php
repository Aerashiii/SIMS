<?php
// Box-delete-handler.php
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
    // Get the Box ID from POST data
    $rentalId = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Check if the Box ID is valid
    if ($rentalId) {
        // Prepare SQL to delete the Box
       $sql = "UPDATE `rental-transaction` SET `deleted` = 'yes' WHERE `id` = ?";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared correctly
        if ($stmt) {
            $stmt->bind_param("i", $rentalId);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Rental deleted successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to delete Rental.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error preparing statement.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid Rental ID.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}

?>

