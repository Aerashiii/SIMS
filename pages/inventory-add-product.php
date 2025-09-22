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
$page = 'inventory-add-product';
require '../includes/header.php';
?>

<main class="main-content-container">
    <div class="add-product-modal-container" id="add-product-modal">
        
        <!-- Go back to Inventory page -->
        <div class="add-product-inventory-button-container">
            <a href="inventory-onhand-product.php" id="add-product-inventory-button">Inventory</a>
        </div>

        <!-- Add Product Form -->
        <div class="add-product-form-container">
            <form action="" id="add-product-form">
                <h2>Add Product</h2>

                <!-- 1. Supplier -->
                <div class="form-group-container" id="add-product-select-supplier-container">
                    <label>Supplier (optional):</label>
                    <div class="add-product-supplier-container">
                        <select id="add-product-select-supplier" name="supplier_id">
                            <option value="">- Select Supplier -</option>
                            <!-- 🔹 Load supplier options from DB if needed -->
                        </select>
                        <a href="../pages/records-add-supplier.php">
                            <button type="button" id="add-product-add-supplier-button">Add Supplier</button>
                        </a>
                    </div>           
                </div>

                <!-- 2. Product Basic Information -->
                <div class="form-group-container">
                    <label>Product Name:</label>
                    <input type="text" id="add-product-name" name="product_name" required>
                </div>

                <div class="form-group-container">
                    <label>Brand:</label>
                    <select id="add-product-brand" name="product_brand">
                        <option value="">- Select Brand -</option>
                        <option value="">- None -</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Category:</label>
                    <select id="add-product-category" name="product_category">
                        <option value="">- Select Category -</option>
                        <option value="">- None -</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Subcategory:</label>
                    <select id="add-product-subcategory" name="product_subcategory">
                        <option value="">- Select Subcategory -</option>
                        <option value="">- None -</option>
                    </select>
                </div>

                <!-- 3. Product Identification -->
                <div class="form-group-container">
                    <label>Barcode:</label>
                    <div class="inventory-add-product-barcode-container">
                        <input type="text" id="add-product-barcode" name="product_barcode" maxlength="13" required>
                        <button type="button" id="inventory-add-product-generate-barcode-button">Generate</button>
                    </div>
                </div>

                <!-- 4. Stock Information -->
                <div class="form-group-container">
                    <label>Quantity:</label>
                    <input type="number" id="add-product-quantity" name="quantity" required>
                </div>

                <div class="form-group-container">
                    <label>Reorder Point:</label>
                    <input type="number" id="add-product-reorder-point" name="reorder_point" required>
                </div>

                <!-- 5. Pricing -->
                <div class="form-group-container">
                    <label>Original Price:</label>
                    <input type="number" step="0.01" id="add-product-original-price" name="original_price" required>
                </div>

                <div class="form-group-container">
                    <label>Selling Price:</label>
                    <input type="number" step="0.01" id="add-product-selling-price" name="selling_price" required>
                </div>

                <!-- 6. Other Information -->
                <div class="form-group-container">
                    <label>Status:</label>
                    <select id="add-product-status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Description:</label>
                    <textarea id="add-product-description" name="description" placeholder="Product Description"></textarea>
                </div>

                <!-- Submit Button -->
                <input type="submit" id="add-product-submit-button" value="Add Product">
            </form>

            <!-- Cancel Button -->
            <button id="add-product-cancel-button">Cancel</button>
        </div>
    </div>
</main>
