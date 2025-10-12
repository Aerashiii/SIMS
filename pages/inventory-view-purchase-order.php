<?php 
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// 🚫 Restrict access if role is "cashier"
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>
            alert('Access Denied: Cashier role cannot access this page.');
            window.location.href='../login.php';
          </script>";
    exit;
}

$page = 'inventory-view-purchase-order';
require '../includes/header.php';
?>

<main class="main-content-container">

<div>
    <div class="order-details-header-container">
        <h2>Purchase Order Details</h2>
        <a href="inventory-purchase-order-product.php" ><button id="purchase-details-back-button">Back</button></a>
    </div>
    <div class="purchase-order-details-main-container">
        <div class="purchase-order-buttons-container">
            <button id="mark-as-complete-btn">Mark as Complete</button>
            <button id="print-purchase-order-btn">Print Receipt</button>
        </div>
        <div class="purchase-order-details-container">
            <div class="purchase-order-detail">
                <label for="">Order Date:</label>
                <span id="order-date"></span>
            </div>
            <div class="purchase-order-detail">
                <label for="">Processed By:</label>
                <span id="processed-by"></span>
            </div>

            <div class="purchase-order-detail">
                <label for="">Supplier</label>
                <span id="supplier-name"></span>
            </div>
            <table id="purchase-order-inventory-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="purchase-order-inventory-tbody">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
            <div class="purchase-order-total-amount-container">
                <label for="">Total:</label>
                <span id="purchase-order-total-amount">0.00</span>
            </div>
            
        </div>
        
    </div>
</div>

  <div id="toast" aria-live="polite"></div>
   
</main>


