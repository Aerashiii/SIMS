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

    $page = 'records-add-category'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>



<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
   <div class="back-category-button-container">
        <a href="records-category.php" id="back-category-button">Back to Category</a>
    </div>  
   <!--| FOR ADD CATEGORY |-->
<div class="add-category-modal-container">
   
    <div class="add-category-modal">
        <h3>Add Category</h3>
        <form action="" id="add-category-form">
            <div class="form-div">
                <label for="" class="add-category-label">Category Name:</label>
                <input type="text" id="add-category-name">
            </div>
            <div class="form-div">
                <label for=""  class="add-category-label">Status:</label>
                <select name="" id="add-category-status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="submit" id="add-category-submit-button">
        </form>
        <button id="add-category-cancel-button">Cancel</button>
        
    </div>
</div>
          
        

      
</main>