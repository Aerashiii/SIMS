
<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}
// 🚫 Check if role is 'cashier' and deny access
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}
    $page ='records-add-product'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>
<main class="main-content-container">
    <div class="back-product-button-container">
        <a href="records-product.php" id="back-product-button">Back to Product</a>
    </div>  
    <!--------| ADD NEW PRODUCT | --------------->
    <div class="add-product-modal-container" id="add-product-modal">
        <div class="add-product-form-container">          
            <form action="" id="add-product-form">
                <h2>Add Product</h2>

                <div class="form-group-container">
                    <label>Product Name:</label>
                    <input type="text" id="add-product-name" name="product_name" required>
                </div>

                <div class="form-group-container">
                    <label>Brand:</label>
                    <select id="add-product-brand" name="product_brand" required>
                    <option value="">- Select Brand -</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Category:</label>
                    <select id="add-product-category" name="product_category" required>
                    <option value="">- Select Category -</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Subcategory:</label>
                    <select id="add-product-subcategory" name="product_subcategory" required>
                    <option value="">- Select Subcategory -</option>
                    </select>
                </div>

                <div class="form-group-container">
                    <label>Barcode:</label>
                    <div class="inventory-add-product-barcode-container">
                    <input type="text" id="add-product-barcode" name="product_barcode" maxlength="13" required>
                    <button type="button" id="inventory-add-product-generate-barcode-button">Generate</button>
                    </div>
                </div>

                <div class="form-group-container">
                    <label>Quantity:</label>
                    <input type="number" id="add-product-quantity" name="quantity" required>
                </div>

                <div class="form-group-container">
                    <label>Reorder Point:</label>
                    <input type="number" id="add-product-reorder-point" name="reorder_point" required>
                </div>

                <div class="form-group-container">
                    <label>Original Price:</label>
                    <input type="number" step="0.01" id="add-product-original-price" name="original_price" required>
                </div>

                <div class="form-group-container">
                    <label>Selling Price:</label>
                    <input type="number" step="0.01" id="add-product-selling-price" name="selling_price" required>
                </div>

                <div class="form-group-container" id="add-product-select-supplier-container">
                    <label>Supplier:</label>
                    <div class="add-product-suplier-container">
                        <input type="text" id="add-product-input-supplier" >
                        <select id="add-product-select-supplier" name="supplier_id" >
                        <option value="">- Select Supplier -</option>
                        </select>
                        <button id="add-product-select-supplier-button" type="button">Select Supplier</button>
                    </div>           
                </div>

                <div class="form-group-container">
                    <label>Status:</label>
                    <select id="add-product-status" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group-container">
                    <label for="">Description</label>
                    <textarea id="add-product-description" name="description" placeholder="Product Description"></textarea>
                </div>
                <input type="submit" id="add-product-submit-button" value="Add Product">
            </form>
            <button id="add-product-cancel-button">Cancel</button>
        </div>
    </div>
</main>