 
 
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

    $page = 'records-subcategory'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>
<main class="main-content-container">
     <?php include 'records-submenu.php'; ?> 
     <div class="category-header-buttons-container">
        <a href="records-category.php"><button id="category-button" class="category-button">Category</button></a>
        <a href="records-subcategory.php"><button id="subcategory-button" class="category-button">Subcategory</button></a>
      </div>
 <!--| SUBCATEGORY TABLE|-->
                    <div class="subcategory-container">
                        <div class="subcategory-table-header-container">
                            <h3>Subcategory:</h3>
                            <select name="" id="subcategory-select-category">
                                <option value="">- Select All -</option>
                            </select>
                            <a href="records-add-subcategory.php"><button id="add-subcategory-button">Add Subcategory</button></a>
                        </div>           
                        <table id="subcategory-table">
                            <tr>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>             
                        </table>
                    </div>

</main>

                    <!--| MODAL FOR EDITING SUBCATEGORY |-->
<div class="edit-subcategory-modal-container" id="edit-subcategory-modal-container">
    <div class="edit-subcategory-modal">
        <button id="subcategory-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Subategory</h2>
        <div class="edit-subcategory-details-container" id="edit-subcategory-details-container">

            <input type="hidden" name="edit-subcetegory-id" id="edit-subcategory-id">
            <label>Category:</label>
            <select name="" id="edit-subcategory-select-category"></select>
            <label for="edit-subcategory-name">Subcategory:</label>
            <input type="text" name="edit-subcategory-name" value="" id="edit-subcategory-name">
            <label for="">Status:</label>
            <select id="edit-subcategory-status" name="edit-subcategory-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>
            
            <button id="save-edit-subcategory-button">Save</button>
        </div>
    </div>
</div>
<!-- | DELETION CONFIRMATION FOR SUBCATEGORY |-->
<div class="delete-subcategory-modal-container">
    <div class="delete-subcategory-modal">
        <p>Are you sure you want to delete this Subcategory?</p>
        <span id="delete-subcategory-name"></span>

        <div class="subcategory-delete-yes-and-no-button">
            <button id="delete-subcategory-yes-button">Yes</button>
            <button id="delete-subcategory-no-button">No</button>
        </div>

    </div>
</div>

