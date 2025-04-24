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
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search" class="inventory-search-input" id="inventory-onhand-products-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-onhand-product-search-submit-button">search</button>
            </div>         
            
            <select name="" id="select-product-by-category"> </select>

        </div>
        <table id="onhand-inventory-table">
            <thead>
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
            </thead>
            <tbody></tbody>
            
        </table>

    </div>
    <!-------------------| LOW STOCK LIST -------------------->
    <!--| #4 |-->  
    <div class="inventory-content-container" id="low-stock-inventory-content-container">
        <div class="low-stock-header-container">
            <h2>Low Stock Products</h2>
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search"  class="inventory-search-input" id="inventory-low-stock-products-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-low-stock-product-search-submit-button">search</button>
            </div> 
            
            <select name="" id="select-low-stock-product-by-category"></select>

        </div>
        <table id="low-stock-inventory-table">
            <thead>
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
            </thead>
            <tbody></tbody>
            
        </table>

    </div>
    <!-------------------| OUT OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="out-stock-inventory-content-container">
        <div class="out-stock-header-container">
            <h2>Out of Stock Products</h2>
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search"  class="inventory-search-input" id="inventory-out-stock-products-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-out-stock-product-search-submit-button">search</button>
            </div> 
            
            <select name="" id="select-out-stock-product-by-category"></select>

        </div>
        <table id="out-stock-inventory-table">
            <thead>
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
            </thead>
            <tbody></tbody>
        </table>

    </div>
    <!-------------------| STOCK IN OF STOCK LIST -------------------->
    <!--| #5 |-->  
    <div class="inventory-content-container" id="stock-in-inventory-content-container">
        <div class="stock-in-header-container">
            <h2>Stock In Products</h2>
            <button id="inventory-stockin-product-selection-button">Select Product</button>        
        </div>
        <table id="stock-in-inventory-table">
            <thead>
                <tr>   
                    <th style="display: none;"></th>    
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>
                        <span id="stock-in-action-text">Action</span>                  
                    </th>
                </tr>
            </thead>
            <tbody id="stock-in-inventory-table-body"></tbody>
        </table>    
         <button id="stock-in-save-button" >Save Stock in</button>
         <div class="confirm-submit-stock-in-modal-container" id="confirm-submit-stock-in-modal-container">
            <div class="confirm-submit-stock-in-modal" id="confirm-submit-stock-in-modal">
                <p>Are you sure you want to submit this stock in?</p>
                <button id="confirm-submit-stock-in-button">Yes</button>
                <button id="cancel-submit-stock-in-button">No</button>
            </div>
         </div>
    </div>
    <!-------------------| PURCHASE ORDER LIST -------------------->
    <!--| #6 |-->  
    <div class="inventory-content-container" id="purchase-order-inventory-content-container">
        <div class="purchase-order-header-container">
            <h2>Purchase Order</h2>
            <div class="search-container">
                <input type="text" placeholder="Search">
                <button>Search</button>
            </div>

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


<!--| MODAL FOR EDITING PRODUCT |-->
<div class="edit-product-modal-container" id="edit-product-modal-container">
    <div class="edit-product-modal">
        <button id="edit-product-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Product</h2>
        <form id="edit-product-form">
        <div class="edit-product-details-container" id="edit-product-details-container">

            <input type="hidden" name="edit-product-id" id="edit-product-id">
            <label for="edit-product-name">Product name:</label>
            <input type="text" name="edit-product-name" value="" id="edit-product-name" required>
            <label for="">Barcode:</label>
            <input type="text" name="edit-product-barcode" id="edit-product-barcode"  required>
            <label for="edit-product-brand">Brand:</label>
            <select name="edit-product-brand" id="edit-product-brand"  required></select>

            <div>
                <div class="edit-category-container" >
                    <label for="">Category:</label>
                    <select name="edit-product-category" id="edit-product-category"  required></select>
                </div>
                <div class="edit-subcategory-container" >
                    <label for="">Subcategory:</label>
                    <select name="edit-product-subcategory" id="edit-product-subcategory"  required></select>
                </div>               
            </div>
            <div>
                <div class="edit-original-price-container" >
                    <label for="">Original Price:</label>
                    <input type="text" name="edit-product-original-price" id="edit-product-original-price"  required>
                </div>
                <div class="edit-selling-price-container" >
                    <label for="">Selling Price:</label>
                    <input type="text" name="edit-product-selling-price" id="edit-product-selling-price"  required>
                </div>               
            </div>
            <div>
                <div class="edit-quantity-container">
                    <label for="">Quantity</label>
                    <input type="text" name="edit-product-quantity" id="edit-product-quantity"  required>
                </div>
                <div class="edit-reorder-point-container">
                    <label for="">Reorder Point:</label>
                    <input type="text" name="edit-product-reorder-point" id="edit-product-reorder-point"  required>
                </div>               
            </div>

            <label for="">Status:</label>
            <select name="" id="edit-product-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>

            <label for="">Supplier:</label>
            <select name="edit-product-select-supplier" id="edit-product-select-supplier"  required></select>

           
                  
            <button id="save-edit-product-button">Save</button>
        </div>
        </form>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR PRODUCT | -->
<div class="delete-product-modal-container">
    <div class="delete-product-modal">
        <p>Are you sure you want to delete this Brand?</p>
        <span id="delete-product-name"></span>

        <div class="product-delete-yes-and-no-button">
            <button id="delete-product-yes-button">Yes</button>
            <button id="delete-product-no-button">No</button>
        </div>

    </div>
</div>

<!---- | MODAL FOR SELECTING PRODUCT FOR STOCK IN |-->
<div class="stockin-product-selection-modal-container">
        <div class="stockin-product-selection-container">
            <div class="stockin-product-selection-header-container">
                <h4>Product Selection</h4>
                <span class="exit-icon" id="stockin-product-selection-exit-button">&times;</span>
            </div>          
            <div class="stockin-product-selection-content-container">
                <div class="stockin-product-selection-search-container">                 
                        <input type="text" placeholder="Search" id="stockin-product-selection-search-input">
                        <button type="submit" name="submit" id="stockin-product-selection-search-submit-button">search</button>                 
                </div>  
                <div class="stockin-product-table-container">
                    <table id="stockin-product-selection-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Barcode</th>
                                <th>Quantity</th>
                                <th>Action</th>                          
                            </tr>
                        </thead>
                        <tbody></tbody>                
                    </table>
                </div>
            </div>
        </div>        
    </div>
