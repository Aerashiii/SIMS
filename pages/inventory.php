<!-- | ALL INVENTORY CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}

    $page ='inventory'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!--| #1 |-->   
    <div class="inventory-header-container">
        <h1>Inventory Management</h1>
        <button id="inventory-add-product-button">Add New Product</button>
    </div>
    <!--| #2 |-->  
    <div class="inventory-switch-content-buttons-container">
        <button id="onhand-product-button" class="active">On Hand Product</button>
        <button id="low-stock-product-button">Low Stock Product</button>
        <button id="out-stock-product-button">Out of Stock Product</button>
        <button id="stock-in-product-button">Stock In</button>
       
        <button id="purchase-order-button">Purchase Order</button>
    </div>

    <!-------------------| ON HAND INVENTORY LIST -------------------->
    <!--| #3 |-->  
    <div class="inventory-content-container active" id="onhand-inventory-content-container" >
        <div class="onhand-header-container">
            <h2>On Hand Inventory List</h2>
            <div class="search-container">
                <input type="text">
                <button>Search</button>
            </div>         
            <select name="" id="">
                <option value=""> -select category-</option>
            </select>

        </div>
        <table id="onhand-inventory-table">
            <tr>
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Reorder Point</th>
                <th>Original Price</th>
                <th>Selling Price</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </table>

    </div>
    <!-------------------| LOW STOCK LIST -------------------->
    <!--| #4 |-->  
    <div class="inventory-content-container" id="low-stock-inventory-content-container">
        <div class="low-stock-header-container">
            <h2>Low Stock Products</h2>
            <div class="search-container">
                <input type="text">
                <button>Search</button>
            </div>
            
            <select name="" id="">
                <option value=""> -select category-</option>
            </select>

        </div>
        <table id="low-stock-inventory-table">
            <tr>
                <th><input type="checkbox"></th>
                <th>Product Name</th>
                <th>Barcode</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>
                    <span id="low-stock-action-text">Action</span>
                    <button id="low-stock-delete-active-checkbox-button">Delete</button>
                </th>
            </tr>

        </table>

    </div>
    <!-------------------| OUT OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="out-stock-inventory-content-container">
        <div class="out-stock-header-container">
            <h2>Out of Stock Products</h2>
            <div class="search-container">
                <input type="text">
                <button>Search</button>
            </div>
            
            <select name="" id="">
                <option value=""> -select category-</option>
            </select>

        </div>
        <table id="out-stock-inventory-table">
            <tr>
                <th><input type="checkbox"></th>
                <th>Product Name</th>
                <th>Barcode</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>
                    <span id="out-stock-action-text">Action</span>
                    <button id="out-stock-delete-active-checkbox-button">Delete</button>
                </th>
            </tr>

        </table>

    </div>
    <!-------------------| STOCK IN OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="stock-in-inventory-content-container">
        <div class="stock-in-header-container">
            <h2>Stock In Products</h2>
            <div>
                <button>Add Product</button>
                <button>Save</button>

            </div>
            
        </div>
        <table id="stock-in-inventory-table">
            <tr>       
                <th>Product Name</th>
                <th>Barcode</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>
                    <span id="stock-in-action-text">Action</span>                  
                </th>
            </tr>
            <tr>
                <td>Dress</td>
                <td>123</td>
                <td>Penshop</td>
                <td><input type="text"></td>
                <td><button>Remove</button></td>
            </tr>

        </table>

    </div>
    <!-------------------| PURCHASE ORDER LIST -------------------->
    <!--| #6 |-->  
    <div class="inventory-content-container" id="purchase-order-inventory-content-container">
        <div class="purchase-order-header-container">
            <h2>Purchase Order</h2>
            <div class="search-container">
                <input type="text">
                <button>Search</button>
            </div>
            
            <select name="" id="">
                <option value=""> -select category-</option>
            </select>

        </div>
        <table id="purchase-order-inventory-table">
            <tr>
                <th><input type="checkbox"></th>
                <th>Product Name</th>
                <th>Barcode</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>
                    <span id="purchase-order-action-text">Action</span>
                    <button id="purchase-order-delete-active-checkbox-button">Delete</button>
                </th>
            </tr>

        </table>

    </div>

</main>

<!--------| ADD NEW PRODUCT | --------------->
<!--| #7 |-->  
<div class="add-product-modal-container">
    <div class="add-product-form-container">
        <form action="" id="add-product-form">
            <h3>Add Product</h3>
            <div class="form-group-container">
                <label>Product Name:</label>
                <input type="text" id="add-product-name"required>
            </div>
            <div class="form-group-container">
                <label>Brand:</label>
                <select name="" id="add-product-brand" required>
                    <option value="">- Select Brand -</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Category:</label>
                <select name="" id="add-product-category" required>
                    <option value="">- Select category -</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Subcategory:</label>
                <select name="" id="add-product-subcategory" required>
                    <option value="">- Select subcategory -</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Barcode:</label>
                <input type="text" id="add-product-barcode" required>
            </div>
            <div class="form-group-container">
                <label>Quantity:</label>
                <input type="text" id="add-product-quantity" required>
            </div>
            <div class="form-group-container">
                <label>Reorder Point:</label>
                <input type="text" id="add-product-reorder-point" required>
            </div>
            <div class="form-group-container">
                <label>Original Price:</label>
                <input type="text"id="add-product-original-price" required>
            </div>
            <div class="form-group-container">
                <label>Selling Price:</label>
                <input type="text" id="add-product-selling-price"  required>
            </div>
            <div class="form-group-container">
                <label>Supplier:</label>
                <select name="" id="add-product-select-supplier">
                    <option value="">- Select Supplier -</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Status:</label>
                <select name="" id="add-product-status" required>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>

            <input type="submit" id="add-product-submit-button">
        </form>
        <button id="add-product-cancel-button">Cancel</button>

    </div>

</div>