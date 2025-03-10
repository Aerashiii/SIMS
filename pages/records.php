<!-- | ALL ANALYTICS CONTENT GOES HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}

    $page = 'records'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'ANALYTICS' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP TO APPLY THE CSS, SCRIPTS, SIDEBAR, AND TOP NAVIGATION.
?>


<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    
    <div class="records-header-container" id="records-header-container"><span class="material-symbols-rounded">menu</span>Record Management</div>
    <div class="records-submenu-container">
        <span class="material-symbols-rounded" id="hide-records-submenu-button">cancel</span>
        <h4>Records Content</h4>
        <ul class="records-submenu-list">
            <li><span class="material-symbols-rounded">category</span>Category</li>
            <li><span class="material-symbols-rounded">sell</span>Brand</li>
            <li><span class="material-symbols-rounded">inventory</span>Products</li>
            <li><span class="material-symbols-rounded">local_shipping</span>Supplier</li>
        </ul>

    </div>

        <!---------------| CATEGORY AND SUBCATEGORY |-------------------------->
        <div class="records-content-container active" id="category-content-container">
                <div class="category-and-subcategory-container">
                    <div class="category-header-buttons-container">
                        <button id="category-button" class="active">Category</button>
                        <button id="subcategory-button">Subcategory</button>          
                    </div>
                    <!--| CATEGORY TABLE|-->
                    <div class="category-container active">
                        
                        <div class="category-header-container">
                            <h3>Category:</h3>
                            <button id="add-category-button">Add Category</button>
                            
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
                    <!--| SUBCATEGORY TABLE|-->
                    <div class="category-container">
                        <div class="subcategory-table-header-container">
                            <h3>Subcategory:</h3>
                            <select name="" id="subcategory-select-category">
                                <option value="">- Select All -</option>
                            </select>
                            <button id="add-subcategory-button">Add Subcategory</button>
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
                </div>
            </div>
            <!-------------| BRAND |------------------->
            <div class="records-content-container" id="brand-content-container" >
                <div class="brand-container">
                    <div class="brand-header-container">
                        <h3>Brand:</h3>
                        <button id="add-brand-button">Add Brand</button>
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
        

            <!---------------| FOR PRODUCT LIST |------------------>
            <div class="records-content-container" id="products-content-container">
                <div class="products-list-container">
                    <div class="product-list-header-container">
                        <h3>Product list:</h3>
                        <button id="product-list-add-product-button">Add Product</button>
                    </div>   
                    <table id="product-list-table">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th>Barcode</th>
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
            </div>


            <!-------------------| SUPPLIER INFORMATION |---------------------->
            <div class="records-content-container" id="supplier-content-container">
                <div class="supplier-information-container">
                    <div class="supplier-info-header-container">
                        <h3>Supplier Information</h3>
                        <button id="add-supplier-button">Add Supplier</button>
                    </div>      
                    <table id="supplier-information-table">
                        <tr>
                            <th>Supplier Name</th>
                            <th>Contact Person</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Supplier type</th>
                            <th>Product Category</th>
                            <th>Payment Terms</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </table>
                </div>
            </div>

      
</main>

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


<!--| MODAL FOR EDITING CATEGORY |-->
<div class="edit-category-modal-container" id="edit-category-modal-container">
    <div class="edit-category-modal">
        <button id="category-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Category</h2>
        <div class="edit-category-details-container" id="edit-category-details-container">
            <input type="hidden" name="edit-cetegory-id" id="edit-category-id">
            <label for="edit-category-name">Category:</label>
            <input type="text" name="edit-category-name" value="" id="edit-category-name">
            <label for="">Status:</label>
            <select id="edit-category-status" name="edit-category-status" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>
            
            <button id="save-edit-category-button">Save</button>
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
<!-- | DELATION CONFIRMATION FOR SUBCATEGORY |-->
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


<!--| FOR ADD BRAND |-->
<div class="add-brand-modal-container">
    <div class="add-brand-modal">
        <h3>Add Brand</h3>
        <form action="" id="add-brand-form">         
            <div class="form-div">
                <label for="" class="add-brand-label">Brand Name:</label>
                <input type="text" id="add-brand-name">
            </div>
            <div class="form-div">
                <label for=""  class="add-brand-label">Status:</label>
                <select name="" id="add-brand-status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="submit" id="add-brand-submit-button">         
        </form>
        <button id="add-brand-cancel-button">Cancel</button>
        
    </div>
</div>
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


 <!-- | MODAL FOR ADDING PRODUCT |--->
 <div class="add-product-modal-container">
    <div class="add-product-modal">
        <h3>Add Product</h3>
        <form action="" id="add-product-form">
            <div>
                <label for="">Product Name:</label>
                <input type="text" name="add-product-name" id="add-product-name">
            </div>
            <div>
                <label for="">Brand:</label>
                <Select name="add-product-brand" id="add-product-brand">
                    <option value="">- select brand -</option>
                </Select>
            </div>
            <div>
                <label for="">Category:</label>
                <Select name="add-product-category" id="add-product-category">
                    <option value="">- select category -</option>
                </Select>
            </div>
            <div>
                <label for="">Subcategory:</label>
                <Select name="add-product-subcategory" id="add-product-subcategory">
                    <option value="">- select subcategory -</option>
                </Select>
            </div>
            <div>
                <label for="">Barcode:</label>
                <input type="text" id="add-product-barcode" >
            </div>
            <div>
                <label for="">Original Price:</label>
                <input type="text" id="add-product-original-price">
            </div>
            <div>
                <label for="">Selling Price:</label>
                <input type="text" id="add-product-selling-price">
            </div>
            <div>
                <label for="">Quantity:</label>
                <input type="text" id="add-product-quantity">
            </div>
            <div>
                <label for="">Reorder Point:</label>
                <input type="text" id="add-product-reorder-point">
            </div>
            <div>
                <label for="">Status:</label>
                <Select id="add-product-status">
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </Select>
            </div>
            <div>
                <label for="">Supplier:</label>
                <Select name="add-product-supplier" id="add-product-select-supplier"></Select>
            </div>
            <input type="submit" id="add-product-submit-button" value="save">
        </form>
        <button id="add-product-cancel-button">Cancel</button>       
    </div>
</div>
<!--| MODAL FOR EDITING PRODUCT |-->
<div class="edit-product-modal-container" id="edit-product-modal-container">
    <div class="edit-product-modal">
        <button id="product-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Product</h2>
        <div class="edit-product-details-container" id="edit-product-details-container">
            <input type="hidden" name="edit-product-id" id="edit-product-id">

            <label for="edit-product-name">Product Name:</label>
            <input type="text" name="edit-product-name" value="" id="edit-product-name">

            <label for="">Category:</label>
            <select name="edit-product-category"  id="edit-product-category"></select>

            <label for="">Subcategory:</label>
            <select name="edit-product-subcategory" id="edit-product-subcategory"></select>

            <label for="">Brand:</label>
            <select name="edit-product-brand" id="edit-product-brand"></select>

            <label for="edit-supplier-nam">Barcode:</label>
           <input type="text" id="edit-product-barcode">

            <label for="">Quantity:</label>
            <input type="text" id="edit-product-quantity">

            <label for="">Reorder Point:</label>
            <input type="text" id="edit-product-reorder-point">

            <label for="">Original Price:</label>
            <input type="text" id="edit-product-original-price">

            <label for="">Selling Price:</label>
            <input type="text" id="edit-product-selling-price">

            <label for="">Status:</label>
            <select name="" id="edit-product-status">
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>

            <label for="edit-product-supplier">Supplier:</label>
            <select name="edit-product-supplier" id="edit-product-supplier"></select>
                       
            <button id="save-edit-product-button">Save</button>
        </div>
    </div>
</div>

<!-- | DELATION CONFIRMATION FOR PRODUCT |-->
<div class="delete-product-modal-container">
    <div class="delete-product-modal">
        <p>Are you sure you want to delete this Product?</p>
        <span id="delete-product-name"></span>

        <div class="product-delete-yes-and-no-button">
            <button id="delete-product-yes-button">Yes</button>
            <button id="delete-product-no-button">No</button>
        </div>

    </div>
</div>

<!-----------| FOR ADDING SUPPLIER |--------------------->

<div class="add-supplier-modal-container">
    <div class="add-supplier-modal">
        <h3>Add Supplier</h3>
        <form action="" id="add-supplier-form">
            <div>
                <label for="">Supplier Name:</label>
                <input type="text" id="add-supplier-name" required>
            </div>
            <div>
                <label for="">Contact Person:</label>
                <input type="text" id="add-supplier-contact-person" required>
            </div>
            <div>
                <label for="">Phone Number:</label>
                <input type="text" id="add-supplier-phone-number" required>
            </div>
            <div>
                <label for="">Address:</label>
                <input type="text" id="add-supplier-address" required>
            </div>
            <div>
                <label for="">Supplier Type:</label>
                <select name="" id="add-supplier-type" required>
                    <option value=""></option>
                    <option value="Product Supplier">Product Supplier</option>
                    <option value="Service Provider">Service Provider</option>
                    <option value="Raw Material Supplier">Raw Material Supplier</option>
                    <option value="Rental Box Supplier">Rental Box Supplier</option>
                </select>
            </div>
            <div>
                <label for="">Product Category:</label>
                <select name="" id="add-supplier-product-category" required>
                    <option value=""></option>
                </select>
            </div>
            <div>
                <label for="">Payment Terms:</label>
                <Select id="add-supplier-payment-terms" required>
                    <option value=""></option>
                </Select>
            </div>
            <div>
                <label for="">Note:</label>
                <input type="text" id="add-supplier-note" >
            </div>
            <input type="Submit" id="add-supplier-submit-button">
        </form>
        <button id="add-supplier-cancel-button">Cancel</button>
    </div>
</div>
<!--| MODAL FOR EDITING SUPPLIER |-->
<div class="edit-supplier-modal-container" id="edit-supplier-modal-container">
    <div class="edit-supplier-modal">
        <button id="supplier-edit-exit-button"><img src="../assets/images/icons/exit.png" alt=""></button>
        <h2>Edit Supplier</h2>
        <div class="edit-supplier-details-container" id="edit-supplier-details-container">
            <input type="hidden" name="edit-supplier-id" id="edit-supplier-id">

            <label for="edit-supplier-name">Supplier Name:</label>
            <input type="text" name="edit-supplier-name" value="" id="edit-supplier-name">

            <label for="">Contact Person:</label>
            <input type="text" id="edit-supplier-contact-person">

            <label for="edit-supplier-name">Contact Number:</label>
            <input type="text" name="edit-supplier-contact-number" value="" id="edit-supplier-contact-number">

            <label for="">Address:</label>
            <input type="text" id="edit-supplier-address">

            <label for="edit-supplier-name">Supplier Type:</label>
            <select name="edit-supplier-type" value="" id="edit-supplier-type" >
                    <option value="Product Supplier">Product Supplier</option>
                    <option value="Service Provider">Service Provider</option>
                    <option value="Raw Material Supplier">Raw Material Supplier</option>
                    <option value="Rental Box Supplier">Rental Box Supplier</option>
                </select>

            <label for="">Product Category:</label>
            <select name="" id="edit-supplier-product-category"></select>

            <label for="edit-supplier-name">Payment Terms:</label>
            <select name="edit-supplier-payment-terms" value="" id="edit-supplier-payment-terms"></select>

            <label for="">Note:</label>
            <input type="text" id="edit-supplier-note">
                       
            <button id="save-edit-supplier-button">Save</button>
        </div>
    </div>
</div>
<!-- | DELATION CONFIRMATION FOR SUPPLIER |-->
<div class="delete-supplier-modal-container">
    <div class="delete-supplier-modal">
        <p>Are you sure you want to delete this Supplier?</p>
        <span id="delete-supplier-name"></span>

        <div class="supplier-delete-yes-and-no-button">
            <button id="delete-supplier-yes-button">Yes</button>
            <button id="delete-supplier-no-button">No</button>
        </div>

    </div>
</div>






