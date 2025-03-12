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
        <div class="search-container">
            <input type="text" placeholder="Search">
            
            <div class="report-type-selection">
                <select name="report_type" id="report_type" required>
                    <option value="" >Report Type</option> 
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            <div class="report-category-selection">
                <select name="report_type" id="report_type" required>
                    <option value="" >Report Category</option> 
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            <div class= "report-date-range">
                <input type="date" id="start" name="report-start" value="" />
            </div>
            
            <button>Search</button>
        </div>

        <button id="export-report-button">Export</button>
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
    
</main>
