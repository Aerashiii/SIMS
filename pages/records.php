<!-- | ALL ANALYTICS CONTENT GOES HERE |-->

<?php 
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
                    <th>Original Price</th>
                    <th>Reorder Point</th>
                    <th>Selling Price</th>
                    <th>Supplier</th>
                    <th>Date Added</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Jeans</td>
                    <td>Dress</td>
                    <td>maong</td>
                    <td>RRJ</td>
                    <td>324234</td>
                    <td>100</td>
                    <td>700</td>
                    <td>123</td>
                    <td>1399</td>
                    <td>gensan warehouse</td>
                    <td>december 20 2025</td>
                    <td>active</td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
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
                    <th>Date Added</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Benjar</td>
                    <td>Benjar</td>
                    <td>09757579376</td>
                    <td>Fatima Gensan City</td>
                    <td>daily</td>
                    <td>Dress</td>
                    <td>cash</td>
                    <td>December 21 2024</td>
                    <td>Note</td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                    
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
                <input type="text" id="category-name">
            </div>
            <div class="form-div">
                <label for=""  class="add-category-label">Status:</label>
                <select name="" id="category-status">
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