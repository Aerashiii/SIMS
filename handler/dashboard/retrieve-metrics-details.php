<?php
// retrieve-metrics-details.php
header('Content-Type: application/json');

// Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

$response = [
    'success' => true,
    'data' => [
        'total_sales' => 0,
        'total_products' => 0,
        'low_stock_items' => 0,
        'rented_quantity' => 0,
        'total_expenses' => 0,
        'total_value' => 0,
        'total_pending_orders' => 0,
        'total_rental_boxes' => 0
    ],
    'errors' => []
];

try {
    // 🟢 Total Sales
    $sql = "SELECT SUM(total_payment) AS total_sales FROM `sales-transaction` WHERE deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_sales'] = number_format($row['total_sales'] ?? 0, 2);
    }

    // 🟢 Total Inventory Value (based on stock * price)
    $sql = "SELECT SUM(quantity * original_price) AS total_value 
            FROM `products` 
            WHERE status='active' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_value'] = number_format($row['total_value'] ?? 0, 2);
    }

    // 🟢 Total Products Count
    $sql = "SELECT SUM(quantity) AS total_products 
            FROM `products` 
            WHERE status='active' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_products'] = $row['total_products'] ?? 0;
    }

    // 🟢 Total Rental Boxes (number of active boxes)
    $sql = "SELECT COUNT(*) AS total_rental_boxes 
            FROM `rentalbox` 
            WHERE status='active' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_rental_boxes'] = $row['total_rental_boxes'] ?? 0;
    }

    // 🟢 Low Stock Items
    $sql = "SELECT COUNT(*) AS low_stock_items 
            FROM `products` 
            WHERE quantity <= reorder_point AND status='active' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['low_stock_items'] = $row['low_stock_items'] ?? 0;
    }

    // 🟢 Total Expenses (based on purchased stock * cost)
    $sql = "SELECT SUM(original_price * quantity) AS total_expenses 
            FROM `products` 
            WHERE status='active' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_expenses'] = number_format($row['total_expenses'] ?? 0, 2);
    }

    // 🟢 Pending Purchase Orders
    $sql = "SELECT SUM(quantity) AS total_pending_orders 
            FROM `purchase-order` 
            WHERE status='pending' AND deleted='no'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['total_pending_orders'] = $row['total_pending_orders'] ?? 0;
    }

    // 🟢 Total Rented Quantity
    $sql = "SELECT SUM(rented_quantity) AS rented_quantity 
            FROM `rental-transaction` 
            WHERE status='active'";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        $response['data']['rented_quantity'] = $row['rented_quantity'] ?? 0;
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>
