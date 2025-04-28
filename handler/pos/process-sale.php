<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to return JSON
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data
    $cart = json_decode($_POST['cart'], true);
    $total_items = $_POST['total_items'];
    $total_payment = $_POST['total_payment'];
    $cash = $_POST['cash'];
    $change = $_POST['change'];
    $payment_method = $_POST['payment_method'];
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];

    $conn->begin_transaction();

    try {
        // Insert transaction
        $stmt = $conn->prepare("INSERT INTO `sales-transaction` (`total_items`, `total_payment`, `cash`, `change`, `payment_method`, `customer_name`, `contact_number`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("iiidsss", $total_items, $total_payment, $cash, $change, $payment_method, $customer_name, $contact_number);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (Insert Transaction): " . $stmt->error);
        }

        $transaction_id = $stmt->insert_id;
        $stmt->close();

        // Insert product sales records
        $productSalesStmt = $conn->prepare("INSERT INTO `product-sales` (`transact_ID`, `product_id`, `quantity_sold`, `total_sale`) VALUES (?, ?, ?, ?)");
        if (!$productSalesStmt) {
            throw new Exception("Prepare failed (Product Sales): " . $conn->error);
        }

        // Update product stock and insert product sales
        $updateStmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE barcode = ?");
        if (!$updateStmt) {
            throw new Exception("Prepare failed (Update): " . $conn->error);
        }

        foreach ($cart as $item) {
            $qty = (int)$item['quantity'];
            $barcode = $item['barcode'];
            $total = $item['total'];

            // Update product quantity
            $updateStmt->bind_param("is", $qty, $barcode);
            if (!$updateStmt->execute()) {
                throw new Exception("Execute failed (Update): " . $updateStmt->error);
            }

            // Get product ID
            $productIdStmt = $conn->prepare("SELECT id FROM products WHERE barcode = ?");
            $productIdStmt->bind_param("s", $barcode);
            $productIdStmt->execute();
            $productIdResult = $productIdStmt->get_result();
            
            if ($productIdResult->num_rows > 0) {
                $product = $productIdResult->fetch_assoc();
                $product_id = $product['id'];
                
                // Insert into product-sales table
                $productSalesStmt->bind_param("iiid", $transaction_id, $product_id, $qty, $total);
                if (!$productSalesStmt->execute()) {
                    throw new Exception("Execute failed (Product Sales): " . $productSalesStmt->error);
                }
            }
            $productIdStmt->close();
        }
        
        $updateStmt->close();
        $productSalesStmt->close();

        // Commit if all succeeded
        $conn->commit();

        echo json_encode(["success" => true, "transaction_id" => $transaction_id]);
    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Transaction failed.",
            "error" => $e->getMessage()
        ]);
    }
}
?>