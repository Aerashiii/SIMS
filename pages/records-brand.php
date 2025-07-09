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

    $page = 'records-brand'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>

 
 
 <!-------------| BRAND |------------------->
<main class="main-content-container">
     <?php include 'records-submenu.php'; ?>
    <div class="records-content-container" id="brand-content-container" >
        <div class="brand-container">
            <div class="brand-header-container">
                <h3>Brand:</h3>
                <a href="records-add-brand.php"><button id="add-brand-button">Add Brand</button></a>
            </div>     
            <table id="brand-table">
                <tr>
                    <th>Brand</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>                          
            </table>
        </div>
    </div>
</main>



    <!--| MODAL FOR EDITING BRAND |-->
<div class="edit-brand-modal-container" id="edit-brand-modal-container">
    <div class="edit-brand-modal">
        <button id="brand-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Brand</h2>
        <div class="edit-brand-details-container" id="edit-brand-details-container">
            <input type="hidden" name="edit-brand-id" id="edit-brand-id">
            <label for="edit-brand-name">Brand:</label>
            <input type="text" name="edit-brand-name" value="" id="edit-brand-name">
            <label for="">Status:</label>
            <select id="edit-brand-status" name="edit-brand-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>
            
            <button id="save-edit-brand-button">Save</button>
        </div>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR BRAND |-->
<div class="delete-brand-modal-container">
    <div class="delete-brand-modal">
        <p>Are you sure you want to delete this Brand?</p>
        <span id="delete-brand-name"></span>
        <div class="brand-delete-yes-and-no-button">
            <button id="delete-brand-yes-button">Yes</button>
            <button id="delete-brand-no-button">No</button>
        </div>

    </div>
</div>
