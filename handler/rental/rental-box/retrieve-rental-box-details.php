<?php
// retrieve-rental-box-details.php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

$response = ["success" => false, "message" => "Unknown error occurred."];

try {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simsdb";

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_GET['box_id'])) {
        throw new Exception("Box ID not provided.");
    }

    $boxId = intval($_GET['box_id']);

    // ✅ Corrected table name: rental_box
    $stmt = $conn->prepare("SELECT * FROM rental_box WHERE box_id = ?");
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $boxId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $rentalBox = $result->fetch_assoc();
        $response = ["success" => true, "data" => $rentalBox];
    } else {
        throw new Exception("Rental box not found.");
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    $response = ["success" => false, "message" => $e->getMessage()];
}

echo json_encode($response);
exit;
?>
