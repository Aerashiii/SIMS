<?php 
session_start();

// Authentication check
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Authorization check
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}

$page = 'report-inventory';
require '../../includes/header.php';
include 'reports.php';

?>

<main class="reports-main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
 

  <!-------------------| ON HAND INVENTORY LIST -------------------->
    <!--| #3 |-->  
    <div class="inventory-content-container" id="onhand-inventory-content-container" >
        <div class="reports-onhand-header-container">
            <h2>On Hand Inventory List</h2>
            <select name="" class="inventory-select-category" id="report-onhand-select-product-by-category"> </select>
            <div class="pdf-and-excel-button-container">
                <button id="report-inventory-onhand-pdf-button" class="pdf-button" alt="Export to PDF"> 
                    <span class="fa fa-file-pdf" style="font-size: 24px; color: red;"></span>                      
                </button>
                <button id="report-inventory-onhand-excel-button" class="excel-button">
                    <span class="fa fa-file-excel" style="font-size: 24px; color: green;"></span>
                </button>
            </div>
        
        </div>
        <div class="report-inventory-table-container">
            <table id="reports-onhand-inventory-table" class="reports-inventory-table">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Product Name</th>
                        <th>Category</th>                
                        <th>Stock Quantity</th>
                        <th>Reorder Point</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Total Stock Value</th>                  
                        <th>Status</th>                  
                    </tr>
                </thead>
                <tbody></tbody>               
            </table>
        </div>
    </div>
    <!-------------------| LOW STOCK LIST -------------------->
    <!--| #4 |-->  
    <div class="inventory-content-container" id="report-low-stock-inventory-content-container">
        <div class="reports-low-stock-header-container">
            <h2>Low Stock Products</h2>
            <select name="" class="inventory-select-category" id="report-select-low-stock-product-by-category"></select>
            <div class="pdf-and-excel-button-container">
                <button id="report-inventory-low-stock-pdf-button" class="pdf-button"> 
                    <span class="fa fa-file-pdf" style="font-size: 24px; color: red;"></span>                      
                </button>
                <button id="report-inventory-low-stock-excel-button" class="excel-button">
                    <span class="fa fa-file-excel" style="font-size: 24px; color: green;"></span>
                </button>
            </div>
        </div>
        <div  class="report-inventory-table-container">
            <table id="report-low-stock-inventory-table" class="reports-inventory-table">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Product Name</th>
                        <th>Category</th>                
                        <th>Stock Quantity</th>
                        <th>Reorder Point</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Total Stock Value</th>                  
                        <th>Status</th>      
                    </tr>   
                </thead>
                <tbody></tbody>             
            </table>
        </div>
       

    </div>
    <!-------------------| OUT OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="report-out-stock-inventory-content-container">
        <div class="reports-out-stock-header-container">
            <h2>Out of Stock Products</h2>
            <select name="" class="inventory-select-category" id="report-select-out-stock-product-by-category"></select>
            <div class="pdf-and-excel-button-container">
                <button id="report-inventory-out-stock-pdf-button" class="pdf-button"> 
                    <span class="fa fa-file-pdf" style="font-size: 24px; color: red;"></span>                      
                </button>
                <button id="report-inventory-out-stock-excel-button" class="excel-button">
                    <span class="fa fa-file-excel" style="font-size: 24px; color: green;"></span>
                </button>
            </div>
        </div>
        <div class="report-inventory-table-container">
            <table id="report-out-stock-inventory-table" class="reports-inventory-table">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Product Name</th>
                        <th>Category</th>                
                        <th>Stock Quantity</th>
                        <th>Reorder Point</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Total Stock Value</th>                  
                        <th>Status</th>      
                    </tr>   
                </thead>
                <tbody></tbody>
            </table>
        </div>
       
    </div>



</main>