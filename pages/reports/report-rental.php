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

$page = 'report-rental';
require '../../includes/header.php';
include 'reports.php';

?>
<main class="reports-main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->

  <div class="report-rental-content-container" id="onhand-inventory-content-container" >
          <div class="report-rental-header-container">
              <h2>Report rental Transaction</h2>
              <div class="pdf-and-excel-button-container">
                  <button id="report-rental-pdf-button" class="pdf-button" alt="Export to PDF"> 
                      <span class="fa fa-file-pdf" style="font-size: 24px; color: red;"></span>                      
                  </button>
                  <button id="report-rental-excel-button" class="excel-button">
                      <span class="fa fa-file-excel" style="font-size: 24px; color: green;"></span>
                  </button>
              </div>
          
          </div>
          <div class="report-rental-table-container">
              <table id="report-rental-table" class="report-rental-table">
                  <thead>
                      <tr>
                          <th>Rental Id</th>
                          <th>Renter Name</th>
                          <th>Item Rented</th>
                          <th>Quantity</th>                
                          <th>Rental Fee</th>
                          <th>Date Rented</th>
                          <th>Due Date</th> 
                          <th>Status</th>                                                                                             
                      </tr>
                  </thead>
                  <tbody></tbody>               
              </table>
          </div>
      </div>
</main>