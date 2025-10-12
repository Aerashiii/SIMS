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
    $page ='inventory-stockin-products'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>
<style>
    #stock-in-product-button{
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
        <a href="inventory-onhand-product.php"><button id="onhand-product-button" >On Hand Product</button></a>
        <a href="inventory-lowstock-product.php"><button id="low-stock-product-button">Low Stock Product</button></a>
        <a href="inventory-outstock-product.php"><button id="out-stock-product-button">Out of Stock Product</button></a>
        <a href="inventory-stockin-product.php"><button id="stock-in-product-button">Stock In</button></a>
        <a href="inventory-purchase-order-product.php"><button id="purchase-order-button">Purchase Order</button></a>
    </div>
    
     <!-------------------| STOCK IN OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="stock-in-inventory-content-container">
        <div class="stock-in-header-container">
            <h2>Stock In Products</h2>
            <button id="inventory-stockin-product-selection-button">Select Product</button>        
        </div>
        <table id="stock-in-inventory-table">
            <thead>
                <tr>   
                    <th style="display: none;"></th>    
                    <th>Description</th>
                    <th>Barcode</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>
                        <span id="stock-in-action-text">Action</span>                  
                    </th>
                </tr>
            </thead>
            <tbody id="stock-in-inventory-table-body"></tbody>
        </table>    
         <button id="stock-in-save-button" >Save Stock in</button>
         <div class="confirm-submit-stock-in-modal-container" id="confirm-submit-stock-in-modal-container">
            <div class="confirm-submit-stock-in-modal" id="confirm-submit-stock-in-modal">
                <p>Are you sure you want to submit this stock in?</p>
                <button id="confirm-submit-stock-in-button">Yes</button>
                <button id="cancel-submit-stock-in-button">No</button>
            </div>
         </div>
    </div>
</main>

<!---- | MODAL FOR SELECTING PRODUCT FOR STOCK IN |-->
<div class="stockin-product-selection-modal-container">
        <div class="stockin-product-selection-container">
            <div class="stockin-product-selection-header-container">
                <h4>Product Selection</h4>
                <span class="exit-icon" id="stockin-product-selection-exit-button">&times;</span>
            </div>          
            <div class="stockin-product-selection-content-container">
                <div class="stockin-product-selection-search-container">                 
                        <input type="text" placeholder="Search" id="stockin-product-selection-search-input">
                        <button type="submit" name="submit" id="stockin-product-selection-search-submit-button">search</button>                 
                </div>  
                <div class="stockin-product-table-container">
                    <table id="stockin-product-selection-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Brand</th>
                                <th>Barcode</th>
                                <th>Quantity</th>
                                <th>Action</th>                          
                            </tr>
                        </thead>
                        <tbody></tbody>                
                    </table>
                </div>
            </div>
        </div>        
    </div>