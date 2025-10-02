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

$page = 'records-category';
require '../includes/header.php';
?>
<style>
    .category-button{
        background-color: #B2CF9B;
        padding:5px 10px;
        font-weight: bold;
        cursor:pointer;
        border:none;
        border-radius:3px;
        width:100px;
    }
    .category-header-buttons-container button:hover{
        background-color: #B2CF9B;
        color: #ffffff;
    }

</style>

<main class="main-content-container">
    <?php include 'records-submenu.php'; ?>

    <div class="records-content-container active" id="category-content-container">
        <div class="category-and-subcategory-container">
            <div class="category-header-buttons-container">
                <a href="records-category.php"><button class="category-button">Category</button></a>
                <a href="records-subcategory.php"><button class="subcategory-button">Subcategory</button></a>
            </div>

            <div class="category-container active">
                <div class="category-header-container">
                    <h3>Category:</h3>
                    <a href="records-add-category.php"><button id="add-category-button">Add Category</button></a>
                </div>

              
                <table id="category-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Edit Modal -->
<!-- ✅ Edit Modal -->
<div class="edit-category-modal-container" id="edit-category-modal-container">
    <div class="edit-category-modal">
        <button id="category-edit-exit-button" class="category-edit-exit-button">X</button>
        <h2>Edit Category</h2>
        <div class="edit-category-details-container"><!-- ✅ wrapper added -->
            <input type="hidden" id="edit-category-id">
            <label for="edit-category-name">Category:</label>
            <input type="text" id="edit-category-name">
            <label>Status:</label>
            <select id="edit-category-status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="button" id="save-edit-category-button">Save</button>
        </div>
    </div>
</div>

<!--Delete Modal -->
<div class="delete-category-modal-container" id="delete-category-modal-container">
    <div class="delete-category-modal">
        <p>Are you sure you want to delete this Category?</p>
        <span id="delete-category-name"></span>
        <div class="category-delete-yes-and-no-button">
            <button id="delete-category-yes-button">Yes</button>
            <button id="delete-category-no-button">No</button>
        </div>
    </div>
</div>