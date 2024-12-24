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
    $brandId = intval($_GET['id']); // Corrected variable name

    // Updated SQL query to fetch brand and brand details
    $sql = "
        SELECT * FROM brand WHERE brand_id =?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",  $brandId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $brand = $result->fetch_assoc();
        echo json_encode( $brand);
    } else {
        echo json_encode(['error' => 'Brand not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Brand ID not provided.']);
}

$conn->close();
?>
