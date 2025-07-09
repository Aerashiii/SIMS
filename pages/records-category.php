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

    $page = 'records-category'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>



<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    
    <?php include 'records-submenu.php'; ?> <!--| THIS INCLUDES THE RECORDS SUBMENU |-->

        <!---------------| CATEGORY AND SUBCATEGORY |-------------------------->
        <div class="records-content-container active" id="category-content-container">
                <div class="category-and-subcategory-container">
                    <div class="category-header-buttons-container">
                        <a href="records-category.php"><button id="category-button" class="category-button">Category</button></a>
                        <a href="records-subcategory.php"><button id="subcategory-button" class="category-button">Subcategory</button></a>
                    </div>
                    <!--| CATEGORY TABLE|-->
                    <div class="category-container active">
                        
                        <div class="category-header-container">
                            <h3>Category:</h3>
                            <a href="records-add-category.php"><button id="add-category-button">Add Category</button></a>
                        </div>
                        <table id="category-table">
                            <tr>
                                <th>Category</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>            
                        </table>
                    </div>
                   
                </div>
            </div>
</main>



<!--| MODAL FOR EDITING CATEGORY |--> 
<div class="edit-category-modal-container" id="edit-category-modal-container">
    <div class="edit-category-modal">
        <button id="category-edit-exit-button" class="category-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Category</h2>
        <div  class="edit-category-details-container" id="edit-category-details-container">
            <input type="hidden" name="edit-cetegory-id" id="edit-category-id">
            <label for="edit-category-name">Category:</label>
            <input type="text" name="edit-category-name" value="" id="edit-category-name">
            <label for="">Status:</label>
            <select id="edit-category-status" name="edit-category-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>          
            <button type="button" id="save-edit-category-button" class="save-edit-category-button">Save</button>
        </div>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR CATEGORY |-->
<div class="delete-category-modal-container">
    <div class="delete-category-modal">
        <p>Are you sure you want to delete this Category?</p>
        <span id="delete-category-name"></span>

        <div class="category-delete-yes-and-no-button">
            <button id="delete-category-yes-button">Yes</button>
            <button id="delete-category-no-button">No</button>
        </div>

    </div>
</div>

