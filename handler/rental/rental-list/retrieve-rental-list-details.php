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

if (isset($_GET['rental_transaction_id'])) {
    $rentalTransactionId = intval($_GET['rental_transaction_id']);

    // Fetch rental transaction and renter info
    $rentalSql = "
        SELECT rtr.*, rnt.renter_name, rnt.contact_number
        FROM `rental-transaction` rtr
        INNER JOIN `renter` rnt ON rtr.renter_id = rnt.renter_id
        WHERE rtr.id = ?
    ";

    $rentalStmt = $conn->prepare($rentalSql);

    if (!$rentalStmt) {
        echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        exit;
    }

    $rentalStmt->bind_param("i", $rentalTransactionId);
    $rentalStmt->execute();
    $rentalResult = $rentalStmt->get_result();

    if ($rentalResult->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Rental transaction not found."]);
        exit;
    }

    $rentalData = $rentalResult->fetch_assoc();

    // Format the rental_start_date and rental_end_date
    $formattedStartDate = date("F j, Y", strtotime($rentalData['rental_start_date']));
    $formattedEndDate = date("F j, Y", strtotime($rentalData['rental_end_date']));

    // Fetch rented boxes
    $boxSql = "
        SELECT rb.quantity, rbx.box_number, rbx.box_size, rbx.rental_fee
        FROM `rented-box-transaction` rb
        INNER JOIN `rentalbox` rbx ON rb.box_id = rbx.box_id
        WHERE rb.rental_transaction_id = ?
    ";

    $boxStmt = $conn->prepare($boxSql);

    if (!$boxStmt) {
        echo json_encode(["success" => false, "message" => "Query preparation failed (boxes): " . $conn->error]);
        exit;
    }

    $boxStmt->bind_param("i", $rentalTransactionId);
    $boxStmt->execute();
    $boxResult = $boxStmt->get_result();

    $rentedBoxes = [];
    while ($box = $boxResult->fetch_assoc()) {
        $rentedBoxes[] = $box;
    }

    $response = [
        "success" => true,
        "data" => [
            "renter_name" => $rentalData['renter_name'],
            "contact_number" => $rentalData['contact_number'],
            "rental_start_date" => $formattedStartDate,
            "rental_end_date" => $formattedEndDate,
            "rented_boxes" => $rentedBoxes
        ]
    ];

    echo json_encode($response);

    $rentalStmt->close();
    $boxStmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Rental transaction ID not provided."]);
}

$conn->close();
?>
