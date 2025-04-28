<?php
session_start(); // Ensure the session is started

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

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $entryType = trim($_POST['entry-type']);

    // Prepare and execute the query to check if the user exists
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if ($password === $user['password']) {
            // Password is correct, set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($_SESSION['role'] === 'admin') {
                header('Location: ../pages/dashboard.php');
                exit;
            } elseif ($_SESSION['role'] === 'cashier') {
                header('Location: ../pages/pos.php');
                exit;
            } else {
                // Other roles can be handled here if needed
                $_SESSION['error'] = 'Unauthorized access!';
                header('Location: ../pages/login.php');
                exit;
            }
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid password!';
            header('Location: ../pages/login.php');
            exit;
        }
    } else {
        // Invalid username
        $_SESSION['error'] = 'Invalid username!';
        header('Location: ../pages/login.php');
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
