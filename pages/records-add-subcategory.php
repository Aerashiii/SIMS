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



<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
   <div class="back-subcategory-button-container">
        <a href="records-subcategory.php" id="back-subcategory-button">Back to Subcategory</a>
    </div>  

<!--| FOR ADD SUBCATEGORY |-->
<div class="add-subcategory-modal-container">
    <div class="add-subcategory-modal">
        <h3>Add Subcategory</h3>
        <form action="" id="add-subcategory-form">
            <div class="form-div">
                <label for="" >Select Category:</label>
                <select name="" id="add-subcategory-select-category">
                    <option value=""> -select category -</option>
                </select>
                
            </div>

            <div class="form-div">
                <label for="" class="add-subcategory-label">Subcategory Name:</label>
                <input type="text" id="add-subcategory-name">
            </div>
            <div class="form-div">
                <label for=""  class="add-subcategory-label">Status:</label>
                <select name="" id="add-subcategory-status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="submit" id="add-subcategory-submit-button">         
        </form>
        <button id="add-subcategory-cancel-button">Cancel</button>
        
    </div>
</div>
          
        

      
</main>