<!-- | ALL INVENTORY CONTENT ONLY HERE |-->

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
    $page ='inventory'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'INVENTORY' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!--| #1 |-->   
    <div class="inventory-header-container">
        <h1>Inventory Management</h1>

        <button type="button" class="button" id="inventory-add-product-button">
            <span class="button__text">Add Product</span>
            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
        </button>
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
            
            <select name="" class="inventory-select-category" id="select-product-by-category"> </select>

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
            
            <select name="" class="inventory-select-category" id="select-low-stock-product-by-category"></select>

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
            
            <select name="" class="inventory-select-category" id="select-out-stock-product-by-category"></select>

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
            <div class="inventory-search-container">         
                <input type="text" placeholder="Search"  class="inventory-search-input" id="inventory-purchase-order-search-input">
                <button type="submit" name="submit" class="inventory-search-submit-button" id="inventory-purchase-order-search-submit-button">search</button>
            </div>     
            <select name=""  class="inventory-select-category" id="select-order-product-by-category"></select>       
            <button id="inventory-add-order-button">
                <span class="add-order-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="20" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                <span class="add-order-text">Add Order</span>
            </button>
            
        </div>
        <table id="purchase-order-inventory-table">
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

</main>

<!--------| ADD NEW PRODUCT | --------------->
<div class="add-product-modal-container" id="add-product-modal">
  <div class="add-product-form-container">
    <form action="" id="add-product-form">
      <h3>Add Product</h3>

      <div class="form-group-container">
        <label>Product Name:</label>
        <input type="text" id="add-product-name" name="product_name" required>
      </div>

      <div class="form-group-container">
        <label>Brand:</label>
        <select id="add-product-brand" name="product_brand" required>
          <option value="">- Select Brand -</option>
        </select>
      </div>

      <div class="form-group-container">
        <label>Category:</label>
        <select id="add-product-category" name="product_category" required>
          <option value="">- Select Category -</option>
        </select>
      </div>

      <div class="form-group-container">
        <label>Subcategory:</label>
        <select id="add-product-subcategory" name="product_subcategory" required>
          <option value="">- Select Subcategory -</option>
        </select>
      </div>

      <div class="form-group-container">
        <label>Barcode:</label>
        <div class="inventory-add-product-barcode-container">
          <input type="text" id="add-product-barcode" name="product_barcode" maxlength="13" required>
          <button type="button" id="inventory-add-product-generate-barcode-button">Generate</button>
        </div>
      </div>

      <div class="form-group-container">
        <label>Quantity:</label>
        <input type="number" id="add-product-quantity" name="quantity" required>
      </div>

      <div class="form-group-container">
        <label>Reorder Point:</label>
        <input type="number" id="add-product-reorder-point" name="reorder_point" required>
      </div>

      <div class="form-group-container">
        <label>Original Price:</label>
        <input type="number" step="0.01" id="add-product-original-price" name="original_price" required>
      </div>

      <div class="form-group-container">
        <label>Selling Price:</label>
        <input type="number" step="0.01" id="add-product-selling-price" name="selling_price" required>
      </div>

      <div class="form-group-container">
        <label>Supplier:</label>
        <select id="add-product-select-supplier" name="supplier_id" required>
          <option value="">- Select Supplier -</option>
        </select>
      </div>

      <div class="form-group-container">
        <label>Status:</label>
        <select id="add-product-status" name="status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <input type="submit" id="add-product-submit-button" value="Add Product">
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



    <!--------| ADD NEW PURCHASE ORDER | --------------->
<!--------| ADD NEW PURCHASE ORDER | --------------->
<!--| #7 |-->  
<div class="add-order-modal-container">
    <div class="add-order-form-container">
        <form action="" id="add-order-product-form">
            <h3>Add Purchase Order</h3>
            <div class="order-form-group-container">
                <label>Product Name:</label>
                <input type="text" id="add-order-product-name" name="product_name" required>
            </div>
            <div class="order-form-group-container">
                <label>Brand:</label>
                <select name="product_brand" id="add-order-product-brand" required>
                    <option value="">- Select Brand -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Category:</label>
                <select name="product_category" id="add-order-product-category" required>
                    <option value="">- Select category -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Subcategory:</label>
                <select name="product_subcategory" id="add-order-product-subcategory" required>
                    <option value="">- Select subcategory -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Barcode:</label>
                <div class="inventory-order-add-product-barcode-container">
                    <input type="text" id="add-order-product-barcode" name="product_barcode" maxlength="13" required>
                    <button type="button" id="inventory-add-order-product-generate-barcode-button">Generate</button>
                </div>
            </div>
            <div class="order-form-group-container">
                <label>Quantity:</label>
                <input type="number" id="add-order-product-quantity" name="quantity" min="1" required>
            </div>
            <div class="order-form-group-container">
                <label>Reorder Point:</label>
                <input type="number" id="add-order-product-reorder-point" name="reorder_point" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Original Price:</label>
                <input type="number" id="add-order-product-original-price" name="original_price" step="0.01" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Selling Price:</label>
                <input type="number" id="add-order-product-selling-price" name="selling_price" step="0.01" min="0" required>
            </div>
            <div class="order-form-group-container">
                <label>Supplier:</label>
                <select name="supplier_id" id="add-order-product-select-supplier" required>
                    <option value="">- Select Supplier -</option>
                </select>
            </div>
            <div class="order-form-group-container">
                <label>Status:</label>
                <select name="status" id="add-order-product-status" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <input type="submit" id="add-order-product-submit-button" value="Submit">
        </form>
        <button id="add-order-product-cancel-button">Cancel</button>
    </div>
</div>