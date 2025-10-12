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

$page = 'inventory-add-product';
require '../includes/header.php';
?>

<main class="main-content-container">
    <div class="add-product-modal-container" id="add-product-modal">
        
        <div class="add-product-inventory-button-container">
            <a href="inventory-onhand-product.php" id="add-product-inventory-button">Inventory</a>
        </div>

        <div class="add-product-form-container">
            <form action="" id="add-product-form">
                <h2>Add Product</h2>

                <!-- Supplier -->
                <div class="form-group-container">
                    <label>Supplier (optional):</label>
                    <div class="add-product-supplier-container">
                        <select id="add-product-select-supplier" name="supplier_id">
                            <option value="">- None -</option>
                        </select>
                        <a href="../pages/records-add-supplier.php">
                            <button type="button" id="add-product-add-supplier-button">Add Supplier</button>
                        </a>
                    </div>           
                </div>

                <!-- Product Name -->
                <div class="form-group-container">
                    <label>Product Name:</label>
                    <input type="text" id="add-product-name" name="product_name" required>
                </div>

                <!-- Brand -->
                <div class="form-group-container">
                    <label>Brand (optional):</label>
                    <select id="add-product-brand" name="product_brand">
                        <option value="">- None -</option>
                    </select>
                </div>

                <!-- Category -->
                <div class="form-group-container">
                    <label>Category (optional):</label>
                    <select id="add-product-category" name="product_category">
                        <option value="">- None -</option>
                    </select>
                </div>

                <!-- Subcategory -->
                <div class="form-group-container">
                    <label>Subcategory (optional):</label>
                    <select id="add-product-subcategory" name="product_subcategory">
                        <option value="">- None -</option>
                    </select>
                </div>

                <!-- Barcode -->
                <div class="form-group-container">
                    <label>Barcode:</label>
                    <div class="inventory-add-product-barcode-container">
                        <input type="text" id="add-product-barcode" name="product_barcode" maxlength="13" required>
                        <button type="button" id="inventory-add-product-generate-barcode-button">Generate</button>
                    </div>
                </div>

                <!-- Stock -->
                <div class="form-group-container">
                    <label>Quantity:</label>
                    <input type="number" id="add-product-quantity" name="quantity" required>
                </div>

                <div class="form-group-container">
                    <label>Reorder Point:</label>
                    <input type="number" id="add-product-reorder-point" name="reorder_point" required>
                </div>

                <!-- Pricing -->
                <div class="form-group-container">
                    <label>Original Price:</label>
                    <input type="number" step="0.01" id="add-product-original-price" name="original_price" required>
                </div>

                <div class="form-group-container">
                    <label>Selling Price:</label>
                    <input type="number" step="0.01" id="add-product-selling-price" name="selling_price" required>
                </div>

                <!-- Status -->
                <div class="form-group-container">
                    <label>Status:</label>
                    <select id="add-product-status" name="status">
                        <option value="active">Active</option>                      
                    </select>
                </div>

                <!-- Description -->
                <div class="form-group-container">
                    <label>Description:</label>
                    <textarea id="add-product-description" name="description" placeholder="Product Description"></textarea>
                </div>

                <input type="submit" id="add-product-submit-button" value="Add Product">
            </form>

            <button id="add-product-cancel-button">Cancel</button>
        </div>
    </div>
</main>
