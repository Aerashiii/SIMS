<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to users

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$response = ['success' => false, 'message' => ''];

try {
    // Verify the request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get and validate input data
    $json = file_get_contents('php://input');
    if (empty($json)) {
        throw new Exception('No input data received');
    }

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }

    // Validate required fields
    $requiredFields = ['customer_name', 'status', 'rental_start_date', 'rental_end_date', 'boxes'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");

    // Extract data with defaults
    $renterName = trim($data['customer_name']);
    $contactNumber = $data['contact_number'] ?? '';
    $status = $data['status'];
    $rentalStart = $data['rental_start_date'];
    $rentalEnd = $data['rental_end_date'];
    $payment = $data['payment'] ?? 0;
    $rentedBoxes = $data['boxes'];

    // Validate dates
    if (strtotime($rentalStart) === false || strtotime($rentalEnd) === false) {
        throw new Exception('Invalid date format');
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into `renter`
        $stmtRenter = $conn->prepare("INSERT INTO renter (renter_name, contact_number) VALUES (?, ?)");
        if (!$stmtRenter) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmtRenter->bind_param("ss", $renterName, $contactNumber);
        if (!$stmtRenter->execute()) {
            throw new Exception('Renter insert failed: ' . $stmtRenter->error);
        }
        $renter_id = $stmtRenter->insert_id;

        // Calculate total quantity
        $totalQuantity = 0;
        foreach ($rentedBoxes as $box) {
            if (!isset($box['quantity']) || !is_numeric($box['quantity'])) {
                throw new Exception('Invalid quantity for box');
            }
            $totalQuantity += (int)$box['quantity'];
        }

        // Insert into `rental-transaction`
        $stmtRental = $conn->prepare("INSERT INTO `rental-transaction` (renter_id, rented_quantity, payment, rental_start_date, rental_end_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmtRental) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmtRental->bind_param("iiisss", $renter_id, $totalQuantity, $payment, $rentalStart, $rentalEnd, $status);
        if (!$stmtRental->execute()) {
            throw new Exception('Rental transaction insert failed: ' . $stmtRental->error);
        }
        $transaction_id = $stmtRental->insert_id;

        // Insert into `rented-box-transaction`
        $stmtBox = $conn->prepare("INSERT INTO `rented-box-transaction` (renter_id, rental_transaction_id, box_id, quantity, date_created) VALUES (?, ?, ?, ?, NOW())");
        if (!$stmtBox) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        
        foreach ($rentedBoxes as $box) {
            if (!isset($box['id']) || !is_numeric($box['id'])) {
                throw new Exception('Invalid box_id');
            }
            $boxId = (int)$box['id'];
            $quantity = (int)$box['quantity'];
            $stmtBox->bind_param("iiii", $renter_id, $transaction_id, $boxId, $quantity);
            if (!$stmtBox->execute()) {
                throw new Exception('Box transaction insert failed: ' . $stmtBox->error);
            }
        }

        // Commit transaction
        $conn->commit();

        $response = [
            "success" => true,
            "message" => "Rental transaction saved successfully.",
            "renter_id" => $renter_id,
            "transaction_id" => $transaction_id
        ];

    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    http_response_code(500);
    $response = [
        "success" => false,
        "message" => "Error: " . $e->getMessage(),
        "error_details" => $e->getFile() . ':' . $e->getLine()
    ];
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    
    // Ensure we only output JSON
    echo json_encode($response);
    exit;
}
?>