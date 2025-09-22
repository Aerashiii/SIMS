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

    $page = 'records-supplier'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>
<main class="main-content-container">
     
    <?php include 'records-submenu.php'; ?> 
            <!-------------------| SUPPLIER INFORMATION |---------------------->
            <div class="records-content-container" id="supplier-content-container">
                <div class="supplier-information-container">
                    <div class="supplier-info-header-container">
                        <h3>Supplier Information</h3>
                        <div class="supplier-info-header-buttons-container">
                            <a href="records-add-supplier.php"><button id="add-supplier-button">Add Supplier</button></a>
                            <a href="inventory-add-product.php"><button id="add-product-from-supplier-button">Add Product</button></a>
                        </div>
                        
                    </div>      
                    <table id="supplier-information-table">
                        <tr>
                            <th>Supplier Name</th>
                            <th>Contact Person</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Supplier type</th>
                            <th>Product Category</th>
                            <th>Payment Terms</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </table>
                </div>
            </div>
</main>


<!--| MODAL FOR EDITING SUPPLIER |-->
<div class="edit-supplier-modal-container" id="edit-supplier-modal-container">
    <div class="edit-supplier-modal">
        <button id="supplier-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Supplier</h2>
        <div class="edit-supplier-details-container" id="edit-supplier-details-container">
            <input type="hidden" name="edit-supplier-id" id="edit-supplier-id">

            <label for="edit-supplier-name">Supplier Name:</label>
            <input type="text" name="edit-supplier-name" value="" id="edit-supplier-name">

            <label for="">Contact Person:</label>
            <input type="text" id="edit-supplier-contact-person">

            <label for="edit-supplier-name">Contact Number:</label>
            <input type="text" name="edit-supplier-contact-number" value="" id="edit-supplier-contact-number">

            <label for="">Address:</label>
            <input type="text" id="edit-supplier-address">

            <label for="edit-supplier-name">Supplier Type:</label>
            <select name="edit-supplier-type" value="" id="edit-supplier-type" >
                    <option value="Product Supplier">Product Supplier</option>
                    <option value="Service Provider">Service Provider</option>
                    <option value="Raw Material Supplier">Raw Material Supplier</option>
                    <option value="Rental Box Supplier">Rental Box Supplier</option>
                </select>

            <label for="">Product Category:</label>
            <select name="" id="edit-supplier-product-category"></select>

            <label for="edit-supplier-name">Payment Terms:</label>
            <select name="edit-supplier-payment-terms" value="" id="edit-supplier-payment-terms">
                <option value="cash">Cash</option>
            </select>

            <label for="">Note:</label>
            <input type="text" id="edit-supplier-note">
                       
            <button id="save-edit-supplier-button">Save</button>
        </div>
    </div>
</div>
<!-- | DELATION CONFIRMATION FOR SUPPLIER |-->
<div class="delete-supplier-modal-container">
    <div class="delete-supplier-modal">
        <p>Are you sure you want to delete this Supplier?</p>
        <span id="delete-supplier-name"></span>

        <div class="supplier-delete-yes-and-no-button">
            <button id="delete-supplier-yes-button">Yes</button>
            <button id="delete-supplier-no-button">No</button>
        </div>

    </div>
</div>
