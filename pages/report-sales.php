<?php 
session_start();

// Authentication check
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Authorization check
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='../login.php';</script>";
    exit;
}

$page = 'report-sales';
require '../includes/header.php';
include 'report-submenu.php';

?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<!-- Include jsPDF Library (for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Include jsPDF AutoTable Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<!-- Include SheetJS Library (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<main class="reports-main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->

    <div class="report-sales-content-container" id="onhand-inventory-content-container" >
        <div class="report-sales-header-container">
            <h2>Report Sales Transaction</h2>
            <div class="pdf-and-excel-button-container">
                <button id="report-sales-pdf-button" class="pdf-button" alt="Export to PDF"> 
                    <span class="fa fa-file-pdf" style="font-size: 24px; color: red;"></span>                      
                </button>
                <button id="report-sales-excel-button" class="excel-button">
                    <span class="fa fa-file-excel" style="font-size: 24px; color: green;"></span>
                </button>
            </div>
        
        </div>
        <div class="report-sales-table-container">
            <table id="report-sales-table" class="report-sales-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date of Sale</th>
                        <th>Sales ID</th>
                        <th>Quantity Sold</th>                
                        <th>Total Sale Amount</th>
                        <th>Payment Method</th>
                        <th>Customer Name</th> 
                        <th>Contact Number</th>                                                                                             
                    </tr>
                </thead>
                <tbody></tbody>               
            </table>
        </div>
    </div>







</main>