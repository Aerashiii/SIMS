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
    $page ='inventory-out-of-stock-products'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>
<style>
    #out-stock-product-button{
        background-color: #99BC85;
        border:none;
        color:#ffffff;
    }
    
</style>
<main class="main-content-container">

<div class="inventory-header-container">
        <h1>Inventory Management</h1>

        <a href="inventory-add-product.php"  class="button" id="inventory-add-product-button">
            <span class="button__text"><img src="../assets/images/icons/ecommerce.png" alt="" class="add-product-cart">Add Product</span>
        </a>
    </div>

<div class="inventory-switch-content-buttons-container">
        <a href="inventory-onhand-product.php"><button id="onhand-product-button" c>On Hand Product</button></a>
        <a href="inventory-lowstock-product.php"><button id="low-stock-product-button">Low Stock Product</button></a>
        <a href="inventory-outstock-product.php"><button id="out-stock-product-button">Out of Stock Product</button></a>
        <a href="inventory-stockin-product.php"><button id="stock-in-product-button">Stock In</button></a>
        <a href="inventory-purchase-order-product.php"><button id="purchase-order-button">Purchase Order</button></a>
    </div>
 <!-------------------| OUT OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="out-stock-inventory-content-container">
        <div class="out-stock-header-container">
            <h2>Out of Stock Products</h2>
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search"  class="inventory-search-input" id="inventory-out-stock-products-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-out-stock-product-search-submit-button">search</button>
            </div> 
            
            <select name="" class="inventory-select-category" id="select-out-stock-product-by-category"></select>

        </div>
        <table id="out-stock-inventory-table">
            <thead>
                <tr>
                  
                    <th>Description</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Reorder Point</th>
                    <th>Original Price</th>
                    <th>Selling Price</th>
                    <th>Action</th>
                </tr>   
            </thead>
            <tbody></tbody>
        </table>

    </div>
</main>

<!--| MODAL FOR EDITING PRODUCT |-->
<div class="edit-product-modal-container" id="edit-product-modal-container">
    <div class="edit-product-modal">
        <button id="edit-product-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Product</h2>
        <form id="edit-product-form">
        <div class="edit-product-details-container" id="edit-product-details-container">

            <input type="hidden" name="edit-product-id" id="edit-product-id">
            <label for="edit-product-name">Product name:</label>
            <input type="text" name="edit-product-name" value="" id="edit-product-name" required>
            <label for="">Barcode:</label>
            <input type="text" name="edit-product-barcode" id="edit-product-barcode"  required>
            <label for="edit-product-brand">Brand:</label>
            <select name="edit-product-brand" id="edit-product-brand"  required></select>

            <div>
                <div class="edit-category-container" >
                    <label for="">Category:</label>
                    <select name="edit-product-category" id="edit-product-category"  required></select>
                </div>
                <div class="edit-subcategory-container" >
                    <label for="">Subcategory:</label>
                    <select name="edit-product-subcategory" id="edit-product-subcategory"  required></select>
                </div>               
            </div>
            <div>
                <div class="edit-original-price-container" >
                    <label for="">Original Price:</label>
                    <input type="text" name="edit-product-original-price" id="edit-product-original-price"  required>
                </div>
                <div class="edit-selling-price-container" >
                    <label for="">Selling Price:</label>
                    <input type="text" name="edit-product-selling-price" id="edit-product-selling-price"  required>
                </div>               
            </div>
            <div>
                <div class="edit-quantity-container">
                    <label for="">Quantity</label>
                    <input type="text" name="edit-product-quantity" id="edit-product-quantity"  required>
                </div>
                <div class="edit-reorder-point-container">
                    <label for="">Reorder Point:</label>
                    <input type="text" name="edit-product-reorder-point" id="edit-product-reorder-point"  required>
                </div>               
            </div>

            <label for="">Status:</label>
            <select name="" id="edit-product-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>

            <label for="">Supplier:</label>
            <select name="edit-product-select-supplier" id="edit-product-select-supplier"  required></select>

            <label for="">Description:</label>
            <textarea name="edit-product-description" id="edit-product-description" rows="4" ></textarea>

           
                  
            <button id="save-edit-product-button">Save</button>
        </div>
        </form>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR PRODUCT | -->
<div class="delete-product-modal-container">
    <div class="delete-product-modal">
        <p>Are you sure you want to delete this Brand?</p>
        <span id="delete-product-name"></span>

        <div class="product-delete-yes-and-no-button">
            <button id="delete-product-yes-button">Yes</button>
            <button id="delete-product-no-button">No</button>
        </div>

    </div>
</div>