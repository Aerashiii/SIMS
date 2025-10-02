<!-- records-add-category.php--->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'cashier') {
    echo "<script>alert('Access Denied: Cashier role cannot access this page.'); window.location.href='login.php';</script>";
    exit;
} 

$page = 'records-add-category';
require '../includes/header.php';
?>

<main class="main-content-container">
   <div class="back-category-button-container">
        <a href="records-category.php" id="back-category-button">Back to Category</a>
    </div>  

   <div class="add-category-modal-container">
      <div class="add-category-modal">
        <h3>Add Category</h3>
        <form action="" id="add-category-form" autocomplete="off">
            <div class="form-div">
                <label class="add-category-label" for="add-category-name">Category Name:</label>
                <input type="text" id="add-category-name" name="category_name" required>
            </div>
            <div class="form-div">
                <label class="add-category-label" for="add-category-status">Status:</label>
                <select id="add-category-status" name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="submit" id="add-category-submit-button" value="Submit">
        </form>
      </div>

      <!-- Toast container -->
      <div id="toast" aria-live="polite"></div>
   </div>


</main>
