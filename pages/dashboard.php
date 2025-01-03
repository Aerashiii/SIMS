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

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!-- | your code here |-->
    <h1>Dashboard</h1>
    <h2>Top Metrics</h2>

    <div class="top-metrics-box-container">
        <div class="total-sales-container">
            <span id="total-sales">0</span>
            <h3>Total Sales</h3>

        </div>
        <div class="inventory-value-container">
            <span id="inventory-value">0</span>
            <h3>Total Sales</h3>

        </div>
        <div class="low-stocks-items-container">
            <span id="low-stock-items">1000</span>
            <h3>Total Sales</h3>

        </div>
        <div class="occupied-rental-boxes-container">
            <span id="occupied-rentas-boxes">0</span>
            <h3>Total Sales</h3>

        </div>

    </div>

    <div class="sales-details-container">
        <div class="recent-sales-container">
            <h2>Recent Sales</h2>
            <table id="recent-sales-table">
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <!-- |SAMPLE|-->
                <tr>
                    <td>December 10 2024</td>
                    <td>Speaker</td>
                    <td>5</td>
                    <td>1500</td>

                </tr>
            </table>

        </div>
        <div class="low-stock-alert-container">
        <h2>LOw Stock Alert</h2>
            <table id="low-stock-alert-table">
                <tr>
                    <th>Product Name</th>
                    <th>Current Stock Level</th>
                    <th>Alert</th>
                  
                </tr>
                <!-- |SAMPLE|-->
                <tr>
                   
                    <td>Speaker</td>
                    <td>5</td>
                    <td>1500</td>

                </tr>
            </table>

        </div>
        <div class="rental-box-summary-container">
        <h2>Rental Box Summary</h2>
            <table id="rental-box-summary-table">
                <tr>
                    <th>Box Number</th>
                    <th>Renter</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <!-- |SAMPLE|-->
                <tr>
                    <td>2024</td>
                    <td>Speaker</td>
                    <td>5</td>
                    <td>December 10 2024</td>

                </tr>
            </table>

        </div>

    </div>


</main>