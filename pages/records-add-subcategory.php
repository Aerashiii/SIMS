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

    $page = 'records-add-subcategory'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>



<main class="main-content-container">
    <div class="back-subcategory-button-container">
        <a href="records-subcategory.php" id="back-subcategory-button">Back to Subcategory</a>
    </div>  

    <div class="add-subcategory-modal-container">
        <div class="add-subcategory-modal">
            <h3>Add Subcategory</h3>
            <form id="add-subcategory-form">
                <div class="form-div">
                    <label>Select Category:</label>
                    <select id="add-subcategory-select-category" name="category_id">
                        <option value="">- Select Category -</option>
                    </select>
                </div>
                <div class="form-div">
                    <label class="add-subcategory-label">Subcategory Name:</label>
                    <input type="text" id="add-subcategory-name" name="subcategory_name">
                </div>
                <div class="form-div">
                    <label class="add-subcategory-label">Status:</label>
                    <select id="add-subcategory-status" name="subcategory_status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <input type="submit" id="add-subcategory-submit-button" value="Add Subcategory">
            </form>
            <button id="add-subcategory-cancel-button" class="add-subcategory-cancel-button">Cancel</button>
        </div>
    </div>
</main>
