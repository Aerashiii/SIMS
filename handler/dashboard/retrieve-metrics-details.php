<?php
// retrieve-metrics-details.php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit();
}

header('Content-Type: application/json');

// Initialize response
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
    // Total sales
    $salesQuery = "SELECT SUM(total_payment) AS total_sales FROM `sales-transaction`";
    $salesResult = $conn->query($salesQuery);
    if ($salesResult) {
        $row = $salesResult->fetch_assoc();
        $response['data']['total_sales'] = number_format($row['total_sales'] ?? 0, 2);
    } else {
        $response['errors'][] = "Sales query failed: " . $conn->error;
    }

    // Total value
    $valueQuery = "SELECT SUM(quantity * original_price) AS total_value FROM `products` WHERE status='active' AND deleted='no'";
    $valueResult = $conn->query($valueQuery);
    if ($valueResult) {
        $row = $valueResult->fetch_assoc();
        $response['data']['total_value'] = number_format($row['total_value'] ?? 0, 2);
    } else {
        $response['errors'][] = "Total value query failed: " . $conn->error;
    }

    // Total products
    $productQuery = "SELECT SUM(quantity) AS total_products FROM `products` WHERE status='active' AND deleted='no'";
    $productResult = $conn->query($productQuery);
    if ($productResult) {
        $row = $productResult->fetch_assoc();
        $response['data']['total_products'] = $row['total_products'] ?? 0;
    } else {
        $response['errors'][] = "Products query failed: " . $conn->error;
    }

    // Total rental boxes
    $rentalBoxesQuery = "SELECT SUM(quantity) AS total_rental_boxes FROM `rentalbox` WHERE status='active' AND deleted='no'";
    $rentalBoxesResult = $conn->query($rentalBoxesQuery);
    if ($rentalBoxesResult) {
        $row = $rentalBoxesResult->fetch_assoc();
        $response['data']['total_rental_boxes'] = $row['total_rental_boxes'] ?? 0;
    } else {
        $response['errors'][] = "Rental boxes query failed: " . $conn->error;
    }

    // Low stock items
    $lowStockQuery = "SELECT COUNT(*) AS low_stock FROM `products` WHERE quantity <= reorder_point AND status='active' AND deleted='no'";
    $lowStockResult = $conn->query($lowStockQuery);
    if ($lowStockResult) {
        $row = $lowStockResult->fetch_assoc();
        $response['data']['low_stock_items'] = $row['low_stock'] ?? 0;
    } else {
        $response['errors'][] = "Low stock query failed: " . $conn->error;
    }

    // Total expenses
    $expensesQuery = "SELECT SUM(selling_price * quantity) AS total_expenses FROM `products` WHERE status='active' AND deleted='no'";
    $expensesResult = $conn->query($expensesQuery);
    if ($expensesResult) {
        $row = $expensesResult->fetch_assoc();
        $response['data']['total_expenses'] = number_format($row['total_expenses'] ?? 0, 2);
    } else {
        $response['errors'][] = "Expenses query failed: " . $conn->error;
    }

    // Pending orders
    $pendingOrdersQuery = "SELECT SUM(quantity) AS total_pending_orders FROM `purchase-order` WHERE status='pending' AND deleted='no'";
    $pendingOrdersResult = $conn->query($pendingOrdersQuery);
    if ($pendingOrdersResult) {
        $row = $pendingOrdersResult->fetch_assoc();
        $response['data']['total_pending_orders'] = $row['total_pending_orders'] ?? 0;
    } else {
        $response['errors'][] = "Pending orders query failed: " . $conn->error;
    }

    //  Rented quantity
    $rentedQuery = "SELECT SUM(rented_quantity) AS rented_quantity FROM `rental-transaction` WHERE status='active'";
    $rentedResult = $conn->query($rentedQuery);
    if ($rentedResult) {
        $row = $rentedResult->fetch_assoc();
        $response['data']['rented_quantity'] = $row['rented_quantity'] ?? 0; // no need for number_format() here
    } else {
        $response['errors'][] = "Rented quantity query failed: " . $conn->error;
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>
