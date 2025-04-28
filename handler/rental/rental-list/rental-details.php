
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
    $boxId = intval($_GET['id']); 

    $sql = "SELECT * FROM `rental-transaction` WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Query preparation failed.']);
        exit;
    }

    $stmt->bind_param("i", $boxId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rentalbox = $result->fetch_assoc();
        echo json_encode($rentalbox);
    } else {
        echo json_encode(['error' => 'Rental not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Rental ID not provided.']);
}

$conn->close();
?>
