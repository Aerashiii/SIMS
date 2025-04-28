 <!-- | ALL DASHBOARD CONTENT ONLY HERE |-->
 
<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}


    $page = 'dashboard'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'DASHBOARD' AND IS USED IN THE HEADER.PHP FILE.
    include '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS, SCRIPT, SIDEBAR, AND TOPNAV ON THIS PAGE.
   
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!-- | your code here |-->
    <h1>Dashboard</h1>
    <h2>Top Metrics</h2>

    <div class="top-metrics-box-container">
        <span><i class="fas fa-undo-alt" id="switch-metrics-boxes-icon"></i> </span>
        <div class="metrics-box-container-one active">
            <div class="metrics-box">
                <span id="total-sales"></span>
                <h3>Total Sales</h3>
            </div>
            <div  class="metrics-box">
                    <span id="total-value"></span>
                    <h3>Total Value</h3>
            </div>
            <div  class="metrics-box">
                <span id="total-products"></span>
                <h3>Total Product</h3>
            </div>
            <div  class="metrics-box">
                    <span id="total-rental-boxes"></span>
                    <h3>Total Rental Boxes</h3>
            </div>

           
        </div>
        <div class="metrics-box-container-two">
            <div  class="metrics-box">
                    <span id="total-expenses"></span>
                    <h3>Total Expenses</h3>
            </div>
            <div  class="metrics-box">
                    <span id="total-pending-orders"></span>
                    <h3>Pending Orders</h3>
            </div>
            <div  class="metrics-box">
                <span id="low-stock-items"></span>
                <h3>Low Stock Product</h3>
            </div>
    
            <div  class="metrics-box">
                <span id="occupied-rental-boxes"></span>
                <h3>Occupied Rental Boxes</h3>
            </div>
          

        </div>
        
    </div>

    <div class="sales-details-container">
        <div class="recent-sales-container">
            <h2>Recent Sales</h2>
            <div class="recent-sales-table-container">
                <table id="recent-sales-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total Items</th>
                            <th>Total</th>
                        </tr>  
                    </thead>
                    <tbody></tbody>                               
                </table>
            </div>           
        </div>
        <div class="low-stock-alert-container">
            <h2>Low Stock Alert</h2>
            <div class="low-stock-alert-table-container">
                <table id="low-stock-alert-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Current Stock Level</th>
                            <th>Alert</th>                       
                        </tr>   
                    </thead>  
                    <tbody></tbody>                  
                </table>
            </div>            
        </div>
        <div class="rental-box-summary-container">
            <h2>Rental Box Summary</h2>
            <div class="rental-box-summary-table-container">
                <table id="rental-box-summary-table">
                    <thead>
                        <tr>
                            <th>Box Number</th>
                            <th>Renter</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>  
                    </thead> 
                    <tbody></tbody>            
                </table>
            </div>           
        </div>
    </div>


</main>