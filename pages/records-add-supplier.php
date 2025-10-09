<?php 
session_start();

// 🚨 Check authentication
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// 🚫 Restrict cashier role
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>
            alert('Access Denied: Cashier role cannot access this page.');
            window.location.href='login.php';
          </script>";
    exit;
}

$page = 'records-add-supplier';
require '../includes/header.php';
?>

<main class="main-content-container">
    <div class="back-supplier-button-container">
        <a href="records-supplier.php" id="back-supplier-button">Back to Supplier</a>
    </div>

    <!-----------| FOR ADDING SUPPLIER |--------------------->
    <div class="add-supplier-modal-container">
        <div class="add-supplier-modal">
            <h3>Add Supplier</h3>
            <form id="add-supplier-form">
                <div>
                    <label>Supplier Name:</label>
                    <input type="text" name="supplier_name" id="add-supplier-name" required>
                </div>
                <div>
                    <label>Contact Person:</label>
                    <input type="text" name="contact_person" id="add-supplier-contact-person" required>
                </div>
                <div>
                    <label>Phone Number:</label>
                    <input type="text" name="phone_number" id="add-supplier-phone-number">
                </div>
                <div>
                    <label>Address:</label>
                    <input type="text" name="address" id="add-supplier-address" required>
                </div>
                <div>
                    <label>Supplier Type:</label>
                    <select name="supplier_type" id="add-supplier-type" required>
                        <option value="Product Supplier">Product Supplier</option>
                        <option value="Service Provider">Service Provider</option>
                        <option value="Raw Material Supplier">Raw Material Supplier</option>
                        <option value="Rental Box Supplier">Rental Box Supplier</option>
                    </select>
                </div>
                <div>
                    <label>Product Category:</label>
                    <select name="product_category_id" id="add-supplier-product-category" required></select>
                </div>
                <div>
                    <label>Payment Terms:</label>
                    <select name="payment_terms" id="add-supplier-payment-terms" required>
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>
                <div>
                    <label>Note:</label>
                    <textarea name="note" id="add-supplier-note" rows="4" placeholder="Enter notes..."></textarea>
                </div>
                <input type="submit" id="add-supplier-submit-button" value="Save">
            </form>
            <a href="records-supplier.php"><button type="button" id="add-supplier-cancel-button">Cancel</button></a>
        </div>
        <div id="toast" aria-live="polite"></div>
    </div>
</main>


