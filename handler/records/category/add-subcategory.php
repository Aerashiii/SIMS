<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the request
    $categoryId = $_POST ['category_id'];
    $subcategory_name = $_POST['subcategory_name'];
    $subcategory_status = $_POST['subcategory_status'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO subcategory (subcategory_name, category_id, status) VALUES (?, ?,?)");
    $stmt->bind_param("sis", $subcategory_name,  $categoryId , $subcategory_status);  // 's' for string

    // Execute the query
    if ($stmt->execute()) {
        // Return success response as JSON
        echo json_encode(["success" => true]);
    } else {
        // Return failure response as JSON
        echo json_encode(["success" => false]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
