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

    $page = 'records-add-brand'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>


<main class="main-content-container">
     <div class="back-brand-button-container">
        <a href="records-brand.php" id="back-brand-button">Back to Brand</a>
    </div>  
    <!--| FOR ADD BRAND |-->
    <div class="add-brand-modal-container">
        <div class="add-brand-modal">
            <h3>Add Brand</h3>
            <form action="" id="add-brand-form">         
                <div class="form-div">
                    <label for="" class="add-brand-label">Brand Name:</label>
                    <input type="text" id="add-brand-name">
                </div>
                <div class="form-div">
                    <label for=""  class="add-brand-label">Status:</label>
                    <select name="" id="add-brand-status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <input type="submit" id="add-brand-submit-button">         
            </form>
            <button id="add-brand-cancel-button">Cancel</button>
            
        </div>
    </div>
</main>