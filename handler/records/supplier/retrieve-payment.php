<?php 

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "simsdb";
    
    // Database connection
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
    }
    
    header('Content-Type: application/json');
    
    
    $sql = "SELECT * FROM payment";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => "SQL prepare failed: " . $conn->error]));
    }
    
    
    if (!$stmt->execute()) {
        die(json_encode(['success' => false, 'message' => "Execution failed: " . $stmt->error]));
    }
    
    $result = $stmt->get_result();
    $payment_data = $result->fetch_all(MYSQLI_ASSOC);
    
   
    
    unset($payment); // Break the reference to avoid side effects
    
    echo json_encode($payment_data);
    
    $stmt->close();
    $conn->close();
?>
    
  

