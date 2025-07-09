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

    $page = 'records-add-supplier'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>
<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <div class="back-supplier-button-container">
        <a href="records-supplier.php" id="back-supplier-button">Back to Supplier</a>
    </div>


<!-----------| FOR ADDING SUPPLIER |--------------------->

<div class="add-supplier-modal-container">
    <div class="add-supplier-modal">
        <h3>Add Supplier</h3>
        <form action="" id="add-supplier-form">
            <div>
                <label for="">Supplier Name:</label>
                <input type="text" id="add-supplier-name" required>
            </div>
            <div>
                <label for="">Contact Person:</label>
                <input type="text" id="add-supplier-contact-person" required>
            </div>
            <div>
                <label for="">Phone Number:</label>
                <input type="text" id="add-supplier-phone-number" >
            </div>
            <div>
                <label for="">Address:</label>
                <input type="text" id="add-supplier-address" required>
            </div>
            <div>
                <label for="">Supplier Type:</label>
                <select name="" id="add-supplier-type" required>
                    <option value=""></option>
                    <option value="Product Supplier">Product Supplier</option>
                    <option value="Service Provider">Service Provider</option>
                    <option value="Raw Material Supplier">Raw Material Supplier</option>
                    <option value="Rental Box Supplier">Rental Box Supplier</option>
                </select>
            </div>
            <div>
                <label for="">Product Category:</label>
                <select name="" id="add-supplier-product-category" required>
                    <option value=""></option>
                </select>
            </div>
            <div>
                <label for="">Payment Terms:</label>
                <Select id="add-supplier-payment-terms" required>
                    <option value="cash">Cash</option>
                </Select>
            </div>
            <div>
                <label for="">Note:</label>
                <textarea id="add-supplier-note" rows="4" cols="50" placeholder="Enter any additional notes or comments here..."></textarea>
            </div>
            <input type="Submit" id="add-supplier-submit-button">
        </form>
        <button id="add-supplier-cancel-button">Cancel</button>
    </div>
</div>