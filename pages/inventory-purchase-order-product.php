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
    $page ='inventory-purchase-order-products'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>
<style>
    #purchase-order-button{
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
    
     <!-------------------| PURCHASE ORDER LIST -------------------->
    <!--| #6 |-->  
    <div class="inventory-content-container" id="purchase-order-inventory-content-container">
        <div class="purchase-order-header-container">
            <h2>Purchase Order</h2>
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search"  class="inventory-search-input" id="inventory-purchase-order-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-purchase-order-search-submit-button">search</button>
            </div>     
            <select name=""  class="inventory-select-category" id="select-order-product-by-category"></select>   
            <a href="inventory-add-order.php">  
                <button id="inventory-add-order-button">
                    <span class="add-order-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="20" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                    <span class="add-order-text">Add Order</span>
                </button> 
            </a>  
            
        </div>
        <table id="purchase-order-inventory-table">
            <thead>
                <tr>              
                    <th>Transaction ID</th>
                    <th>Processed by</th>
                    <th>Total Product</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>                 
                </tr>
            </thead>
            <tbody></tbody>
            
        </table>

    </div>
</main>


<