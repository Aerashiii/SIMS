
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

if (isset($_GET['renter_id'])) {
    $renterId = intval($_GET['renter_id']); 

    $sql = "SELECT * FROM renter WHERE renter_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Query preparation failed.']);
        exit;
    }

    $stmt->bind_param("i", $renterId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $renter = $result->fetch_assoc();
        echo json_encode($renter);
    } else {
        echo json_encode(['error' => 'Renter not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Renter ID not provided.']);
}

$conn->close();
?>
