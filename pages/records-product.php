 <!-- | ALL ANALYTICS CONTENT GOES HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}
// 🚫 Check if role is 'cashier' and deny access
if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='login.php';</script>";
    exit;
}

    $page = 'records-product'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>
 <main class="main-content-container">
    <?php include 'records-submenu.php'; ?> 

    <div class="records-content-container" id="products-content-container">
        <div class="products-list-container">
            <div class="product-list-header-container">
                <h3>Product list:</h3>
               
                <div class="product-filters">
                    
                    <input type="text" id="inventory-onhand-products-search-input" placeholder="Search products...">
                    <select id="select-product-by-category">
                        <option value="">All Categories</option>
                    </select>
                    
                    <a href="inventory-add-product.php">
                        <button id="product-list-add-product-button">Add Product</button>
                    </a>
                </div>
               
            </div>   

            <table id="product-list-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Brand</th>
                        <th>Barcode</th>
                        <th>Quantity</th>
                        <th>Reorder Point</th>
                        <th>Original Price</th>
                        <th>Selling Price</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS will populate here -->
                </tbody>
            </table>
        </div>
    </div>
</main>




