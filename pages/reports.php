<!-- | ALL ANALYTICS CONTENT GOES HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}

    $page = 'reports'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>


<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!-- | your code here |-->
   
    <div class="report-header-container">
        <h1>Report Management</h1>
    </div>
        <div class="search-container">
            <input type="text" placeholder="Search">
            
            <div class="report-type-selection">
                <select name="report_type" id="report_type" required>
                    <option value="" >Report Type</option> 
                    <option value="Inventory">Inventory</option>
                    <option value="Sales">Sales</option>
                    <option value="Rental">Rental</option>
                </select>
            </div>

            <div class="report-category-selection">
                <select name="report_type" id="report_type" required>
                    <option value="" >Report Category</option> 
                    <option value="on-hand-items">On Hand Items</option>
                    <option value="low-stock-product">Low Stock Products</option>
                    <option value="out-stock-product">Out Of Stock Products</option>
                    <option value="purchase-order">Purchase Order</option>
                    <option value="stocks">Stocks</option>
                </select>
            </div>

            <div class= "report-date-range">
                <input type="date" id="start" name="report-start" value="" />
            </div>
            
            <button>Search</button>
        

        <button id="export-report-button">Export</button>
    </div>

    <!-- INVENTORY ON HAND ITEMS-->
    <div class="inventory-onhand-content-container active" id="inventory-onhand-content-container">
                <div class="inventory-onhand-container">
                    <div class="inventory-onhand-header-container">
                        <h3>Inventory (On Hand Items)</h3> 
                    </div>   
                    <table id="inventory-onhand-table">
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Stock Value</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>  
                        
                    </table>
                </div>
     </div>
    
     
    <!-- INVENTORY LOW STOCK -->
    <div class="inventory-lowstock-content-container active" id="inventory-lowstock-content-container">
                <div class="inventory-lowstock-container">
                    <div class="inventory-lowstock-header-container">
                        <h3>Inventory (Low Stock Products)</h3> 
                    </div>   
                    <table id="inventory-lowstock-table">
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Reorder Level</th>
                            <th>Suggested Order QTY</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        
                    </table>
                </div>
     </div>

     
    <!-- INVENTORY OUT OF STOCK -->
    <div class="inventory-outstock-content-container active" id="inventory-outstock-content-container">
                <div class="inventory-outstock-container">
                    <div class="inventory-outstock-header-container">
                        <h3>Inventory (Out of Stock Products)</h3> 
                    </div>   
                    <table id="inventory-outstock-table">
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Last Restocked Date</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        
                    </table>
                </div>
     </div>

     
    <!-- INVENTORY PURCHASE ORDER -->
    <div class="inventory-purchase-order-content-container active" id="inventory-purchase-order-content-container">
                <div class="inventory-purchase-order-container">
                    <div class="inventory-purchase-order-header-container">
                        <h3>Inventory (Purchase Order)</h3> 
                    </div>   
                    <table id="inventory-purchase-order-table">
                        <tr>
                            <th>Supplier Name</th>
                            <th>Order Date</th>
                            <th>Product Orderd </th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Total Cost</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        
                    </table>
                </div>
     </div>

     <!-- INVENTORY STOCKS -->
    <div class="inventory-stocks-content-container active" id="inventory-stocks-content-container">
                <div class="inventory-stocks-container">
                    <div class="inventory-stocks-header-container">
                        <h3>Inventory (Stocks)</h3> 
                    </div>   
                    <table id="inventory-Stocks-table">
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Date of Transaction </th>
                            <th>Transaction Type</th>
                            <th>Quantity Adjusted</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        
                    </table>
                </div>
     </div>

       <!-- SALES-->
    <div class="sales-content-container active" id="sales-content-container">
                <div class="sales-container">
                    <div class="sales-header-container">
                        <h3>Sales</h3> 
                    </div>   
                    <table id="sales-table">
                        <tr>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Product Name </th>
                            <th>Total Payment</th>
                            <th>Payment Method</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        
                    </table>
                </div>
     </div>

        <!-- RENTAL COLLECTION-->
    <div class="rental-collection-content-container active" id="rental-collection-content-container">
                <div class="rental-collection-container">
                    <div class="rental-collection-header-container">
                        <h3>Rental (Collection)</h3> 
                    </div>   
                    <table id="rental-collection-table">
                        <tr>
                            <th>Renter Name</th>
                            <th>Rental Period</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Outstanding Balance</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        
                    </table>
                </div>
     </div>

             <!-- RENTAL STATEMENT OF ACCOUNT-->
    <div class="rental-soa-content-container active" id="rental-soa-content-container">
                <div class="rental-soa-container">
                    <div class="rental-soa-header-container">
                        <h3>Rental (Statement Of Accounts)</h3> 
                    </div>   
                    <table id="rental-soa-table">
                        <tr>
                            <th>Renter Name</th>
                            <th>Transaction Date</th>
                            <th>Description</th>
                            <th>Debit Amount</th>
                            <th>Credit Amount</th>
                            <th>Balance</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>try</td>
                        
                    </table>
                </div>
     </div>

              <!-- RENTAL ACCOUNT RECIEVABLES-->
    <div class="rental-account-receivable-content-container active" id="rental-account-receivable-content-container">
                <div class="rental-account-receivable-container">
                    <div class="rental-account-receivable-header-container">
                        <h3>Rental (Account Receivables)</h3> 
                    </div>   
                    <table id="rental-account-receivable-table">
                        <tr>
                            <th>Renter Name</th>
                            <th>Contact Information</th>
                            <th>Due Date</th>
                            <th>Outstanding Amount</th>
                            <th>Days Overdue</th>
                        </tr>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        <td>123wqwe</td>
                        <td>try</td>
                        
                    </table>
                </div>
     </div>
</main>
