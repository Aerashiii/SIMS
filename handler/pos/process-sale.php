<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'DB connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode($_POST['cart'], true);
    $total_items = (int)$_POST['total_items'];
    $total_payment = (float)$_POST['total_payment'];
    $cash = (float)$_POST['cash'];
    $change = (float)$_POST['change'];
    $payment_method = $_POST['payment_method'];
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];

    // ✅ Fix: Properly get user_id (from POST or session)
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($_SESSION['user_id'] ?? 0);

    if ($user_id === 0) {
        echo json_encode(['success' => false, 'message' => 'Missing user ID. Please log in again.']);
        exit;
    }

    $conn->begin_transaction();

    try {
        // 1️⃣ Insert into sales_transaction
        $stmt = $conn->prepare("
            INSERT INTO sales_transaction 
            (user_id, total_items, total_payment, cash, change_amt, payment_method, customer_name, contact_number, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param(
            "iiiddsss",
            $user_id,
            $total_items,
            $total_payment,
            $cash,
            $change,
            $payment_method,
            $customer_name,
            $contact_number
        );

        if (!$stmt->execute()) {
            throw new Exception("❌ Failed to insert sales transaction: " . $stmt->error);
        }

        $transaction_id = $stmt->insert_id;
        $stmt->close();

        // 2️⃣ Insert into product_sales & update stock
        $insertSale = $conn->prepare("
            INSERT INTO product_sales (transact_id, product_id, quantity_sold, total_sale)
            VALUES (?, ?, ?, ?)
        ");

        $updateStock = $conn->prepare("
            UPDATE products SET quantity = quantity - ? WHERE description = ?
        ");

        foreach ($cart as $item) {
            $productName = $item['name'];
            $quantity = (int)$item['quantity'];
            $totalSale = (float)$item['total'];

            // ✅ Get product ID safely
            $result = $conn->prepare("SELECT id FROM products WHERE description = ?");
            $result->bind_param("s", $productName);
            $result->execute();
            $res = $result->get_result();

            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $product_id = $row['id'];

                $insertSale->bind_param("iiid", $transaction_id, $product_id, $quantity, $totalSale);
                $insertSale->execute();

                $updateStock->bind_param("is", $quantity, $productName);
                $updateStock->execute();
            }
            $result->close();
        }

        $insertSale->close();
        $updateStock->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $conn->close();
}
?>
