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

// 📄 Assign page name for header include
$page = 'inventory-add-order';
require '../includes/header.php';
?>

<main class="main-content-container">
    <div class="purchase-add-order-header-container">
        <h1>Purchase Product </h1>
        <a href="inventory-purchase-order-product.php">Back</a>
    </div>
    <div class="purchase order-products-container">
       
        <div class="purchase-order-products-table-container">
            <table id="purchase-order-products-table">
                <tr>
                    <th>Description</th>
                        <th>Category</th>
                        <th>Quantity</th>                     
                        <th>Original Price</th>                      
                        <th>Action</th>
                </tr>
            </table>
        </div>
        <div class="purchase-order-actions-container">
            <button>Add Product</button>
            <button>Save</button>
        </div>
        
        

    </div>
<div class="add-order-modal-container">
    <div class="add-order-form-container">
        <form action="" id="add-order-product-form">
            <h3>Add Purchase Order</h3>
            <div class="order-form-group-container">
                <label>Product Name:</label>
                <input type="text" id="add-order-product-name" name="product_name" required>
            </div>
            <div class="order-form-group-container">
                <label>Brand:</label>
                <select name="product_brand" id="add-order-product-brand" required>
                    <option value="">- Select Brand -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Category:</label>
                <select name="product_category" id="add-order-product-category" required>
                    <option value="">- Select category -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Subcategory:</label>
                <select name="product_subcategory" id="add-order-product-subcategory" required>
                    <option value="">- Select subcategory -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Barcode:</label>
                <div class="inventory-order-add-product-barcode-container">
                    <input type="text" id="add-order-product-barcode" name="product_barcode" maxlength="13" required>
                    <button type="button" id="inventory-add-order-product-generate-barcode-button">Generate</button>
                </div>
            </div>
            <div class="order-form-group-container">
                <label>Quantity:</label>
                <input type="number" id="add-order-product-quantity" name="quantity" min="1" required>
            </div>
            <div class="order-form-group-container">
                <label>Reorder Point:</label>
                <input type="number" id="add-order-product-reorder-point" name="reorder_point" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Original Price:</label>
                <input type="number" id="add-order-product-original-price" name="original_price" step="0.01" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Selling Price:</label>
                <input type="number" id="add-order-product-selling-price" name="selling_price" step="0.01" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Supplier:</label>
                <select name="supplier_id" id="add-order-product-select-supplier" required>
                    <option value="">- Select Supplier -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Status:</label>
                <select name="status" id="add-order-product-status" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <input type="submit" id="add-order-product-submit-button" value="Submit">
        </form>
        <button id="add-order-product-cancel-button">Cancel</button>
    </div>
</div>
</main>