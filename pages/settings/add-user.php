<?php
// this file is add-user.php this will handler the adding of the user.
// Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'] ?? 'staff'; // Default role is 'staff'
    
    // Basic validation
    if (empty($name) || empty($username) || empty($password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Check if username already exists
        $check_sql = "SELECT id FROM user WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Username already exists! Please choose a different username.');</script>";
        } else {
            // Insert new user
            $insert_sql = "INSERT INTO user (name, username, password, role, profile_pic) VALUES (?, ?, ?, ?, 'default.png')";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssss", $name, $username, $password, $role);

            if ($insert_stmt->execute()) {
                echo "<script>alert('User added successfully!'); window.location.href='user-management.php';</script>";
            } else {
                echo "<script>alert('Failed to add user.');</script>";
            }
        }
    }
}
?>
