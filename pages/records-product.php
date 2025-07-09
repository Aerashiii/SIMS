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
 <!---------------| FOR PRODUCT LIST |------------------>
            <div class="records-content-container" id="products-content-container">
                <div class="products-list-container">
                    <div class="product-list-header-container">
                        <h3>Product list:</h3>
                        <a href="records-add-product.php"><button id="product-list-add-product-button">Add Product</button></a>
                    </div>   
                    <table id="product-list-table">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th>Barcode</th>
                            <th>Quantity</th>
                            <th>Reorder Point</th>
                            <th>Original Price</th>
                            <th>Selling Price</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </table>
                </div>
            </div>

</main>


            
<!--| MODAL FOR EDITING PRODUCT |-->
<div class="edit-product-modal-container" id="edit-product-modal-container">
    <div class="edit-product-modal">
        <button id="product-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Product</h2>
        <div class="edit-product-details-container" id="edit-product-details-container">
            <input type="hidden" name="edit-product-id" id="edit-product-id">

            <label for="edit-product-name">Product Name:</label>
            <input type="text" name="edit-product-name" value="" id="edit-product-name" required>

            <label for="">Category:</label>
            <select name="edit-product-category"  id="edit-product-category" required></select>

            <label for="">Subcategory:</label>
            <select name="edit-product-subcategory" id="edit-product-subcategory" required></select>

            <label for="">Brand:</label>
            <select name="edit-product-brand" id="edit-product-brand" required></select>

            <label for="edit-supplier-nam">Barcode:</label>
           <input type="text" id="edit-product-barcode" required>

            <label for="">Quantity:</label>
            <input type="text" id="edit-product-quantity" required>

            <label for="">Reorder Point:</label>
            <input type="text" id="edit-product-reorder-point" required>

            <label for="">Original Price:</label>
            <input type="text" id="edit-product-original-price" required>

            <label for="">Selling Price:</label>
            <input type="text" id="edit-product-selling-price" required>

            <label for="">Status:</label>
            <select name="" id="edit-product-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>

            <label for="edit-product-supplier">Supplier:</label>
            <select name="edit-product-supplier" id="edit-product-supplier" required></select>
                       
            <button id="save-edit-product-button">Save</button>
        </div>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR PRODUCT |-->
<div class="delete-product-modal-container">
    <div class="delete-product-modal">
        <p>Are you sure you want to delete this Product?</p>
        <span id="delete-product-name"></span>

        <div class="product-delete-yes-and-no-button">
            <button id="delete-product-yes-button">Yes</button>
            <button id="delete-product-no-button">No</button>
        </div>

    </div>
</div>


