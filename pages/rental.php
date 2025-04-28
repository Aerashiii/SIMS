<!-- | ALL RENTAL-BOXES CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}


    $page ='rental'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'RENTAL-BOXES' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
 <!-- | Rental Header|-->  
  <div class="rental-management-header-container">
    <h1>Rental Management</h1>
    <button id="add-rental-button">Add Rental</button>
    <button id="add-rental-back-button">Back</button>
  </div>
    
  <div class="rental-management-content-container">
    <!--|Switch content |-->  
        <div class="rental-boxes-switch-content-buttons-container">
                <button id="renter-list-button" class="active">Renter List</button>
                <button id="rental-box-button">Rental Box</button>
                <button id="rental-button">Rental</button>
        </div>

        <!---------------| FOR RENTER LIST------------------>
        <div class="rental-boxes-content-container active" id="renterlist-content-container">
                    <div class="renter-list-container">
                        <div class="renter-list-header-container">
                            <h3>Renter list:</h3> 
                            <div class="rental-search-container">         
                                <input type="text" placeholder="Search" class="rental-search-input" id="renter-search-input">
                                <button type="submit" name="submit" class="rental-search-submit-button" id="renter-search-submit-button">search</button>
                            </div>
                        </div>   
                        <table class="rental-table" id="renter-list-table">
                            <thead>
                                <tr>
                                    <th>Renter Name</th>
                                    <th>Contact Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>                                                
                        </table>
                    </div>
        </div>

        <!---------------| FOR RENTAL BOX INFORMATION |------------------>
        <div class="rental-boxes-content-container" id="rentalbox-content-container">
                    <div class="rental-box-content-container">
                        <div class="rental-box-header-container">
                            <h3>Rental Box Information:</h3>
                            <div class="rental-search-container">         
                                <input type="text" placeholder="Search" class="rental-search-input" id="rental-box-search-input">
                                <button type="submit" name="submit" class="rental-search-submit-button" id="rental-box-search-submit-button">search</button>
                            </div>   
                            <button id="rental-add-rental-box-button">Add Rental Box</button>
                        </div>   
                        <table class="rental-table" id="rental-box-table">
                            <thead>
                                <tr>
                                    <th>Box Number</th>
                                    <th>Box Size</th>
                                    <th>Width</th>
                                    <th>Length</th>
                                    <th>Rental Fee</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>                                           
                        </table>
                    </div>
        </div>
        <!---------------| FOR RENTAL |------------------>
        <div class="rental-boxes-content-container" id="rental-report-content-container">
                <div class="rental-content-container" id="rental-list-content-container">
                    <div class="rental-header-container">
                        <h3>Rental:</h3>
                        <div class="rental-search-container">         
                                <input type="text" placeholder="Search" class="rental-search-input" id="rental-search-input">
                                <button type="submit" name="submit" class="rental-search-submit-button" id="rental-search-submit-button">search</button>
                        </div> 
                        <div>
                            <select name="" id="rental-select-status">
                                <option value="">All rental</option>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>   
                    <table class="rental-table" id="rental-list-table">
                        <thead>
                            <tr>
                                <th>Renter Name</th>
                                <th>Quantity</th>
                                <th>Payment</th>
                                <th>Rental Start Date</th>
                                <th>Due Date</th>
                                <th>Status</th>                                  
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>                                                           
                    </table>
                </div>


                 <!------| FOR RENTAL VIEW DETAILS |------------>
                 <div class="rental-list-view-details-content-container">
                    <div class="rental-list-view-details-header-container">
                        <h3>Rental Transaction Details</h3>
                        <button id="rental-view-details-exit-button">Exit</button>
                    </div>
                    <div>
                        <label for="">Renter Name:</label>
                        <span id="rental-list-view-details-renter-name"></span>
                    </div>
                    <div>
                        <label for="">Contact Number:</label>
                        <span id="rental-list-view-details-renter-contact-num"></span>
                    </div>
                    <div>
                        <label for="">Rental Start Date:</label>
                        <span id="rental-list-view-details-renter-start-date"></span>
                    </div>
                    <div>
                        <label for="">Rental Due Date:</label>
                        <span id="rental-list-view-details-renter-due-date"></span>
                    </div>
                    <h3>Box Rented List</h3>
                    <div class="box-list-rented-table-container">
                        <table id="box-list-rented-table">
                            <thead>
                                <tr>
                                    <th>Box Number</th>
                                    <th>Box Sizer</th>
                                    <th>Quantity</th>
                                    <th>Total</th>                                  
                                </tr>                              
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                    <div class="box-rented-total-amount-container">
                        <label for="">Total Amount: </label>
                        <span id="box-rented-total-amount"></span>
                    </div>
                 </div>
        </div>
    </div> 


        <!---------------| FOR ADD RENTAL |------------------>
        <div class="add-rental-transaction-container">
            <h3>Add Rental Transaction:</h3>
            <form action="" id="add-rental-transaction-form">
                    <div class="add-rental-transaction-table-container">
                        <table id="add-rental-box-transaction-table">
                            <thead>
                                <tr>
                                    <th>Box Number</th>                           
                                    <th>Box Size</th>
                                    <th>Rental Fee</th> 
                                    <th>Quantity</th> 
                                    <th>Total</th>
                                    <th>Action</th>                                         
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="add-rental-box-transaction-button-container">
                            <button id="add-rental-box-transaction-button">Add Rental Box</button>

                        </div>
                        
                    </div>
                    <div class="add-rental-transaction-total-container">
                        <label for="">Total Amount:</label>
                        <span id="add-rental-transaction-total-amount"></span>              
                    </div>
                    <div class="add-rental-transaction-date-container">
                        <div class="transaction-date-container">
                            <label for="">Rental Start Date:</label>
                            <input type="date" id="rental-start-date" required>
                        </div>
                        <div class="transaction-date-container">
                            <label for="">Rental End Date:</label>
                            <input type="date" id="rental-end-date" required>
                        </div>
                    </div>
                <h3>Customer Information</h3>
                <div class="add-rental-customer-information-container">     
                        <label for="">Customer name:</label>
                        <input type="text" id="customer-name" required>

                        <label for="">Contact Number:</label>
                        <input type="text" id="customer-contact-number" >
                    
                        <label for="">Status:</label>
                        <select name="" id="customer-status" required>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>            
                </div>
                <input type="submit" id="add-rental-transaction-save-button">
           </form>

        </div>




</main>
 
<!---- | MODAL FOR SELECTING RENTAL BOX |-->
<div class="rentalbox-selection-modal-container">
        <div class="rentalbox-selection-container">
            <div class="rentalbox-selection-header-container">
                <h4>Rental Box Selection</h4>
                <span class="exit-icon" id="rentalbox-selection-exit-button">&times;</span>
            </div>          
            <div class="rentalbox-selection-content-container">
                <div class="rentalbox-selection-search-container">                 
                    <input type="text" placeholder="Search" id="rentalbox-selection-search-input">
                    <button type="submit" name="submit" id="rentalbox-selection-search-submit-button">search</button>                 
                </div>  
                <div class="rentalbox-table-container">
                    <table id="rentalbox-selection-table">
                        <thead>
                            <tr>
                                <th>Box Number</th>
                                <th>Size</th>
                                <th>Width</th>
                                <th>Length</th>
                                <th>Rental Fee</th> 
                                <th>Action</th>                         
                            </tr>
                        </thead>
                        <tbody>
                            <!-- JS inserts rows here -->   
                        </tbody>                
                    </table>
                </div>
            </div>
        </div>        
</div>

<!-- | ADD RENTAL BOX MODAL |-->
<div class="rental-add-box-rental-modal-container">
    <div class="rental-add-box-rental-modal">
        <h2>Add Box Rental</h2>
        <form action="" id="rental-add-rental-box-form">
            <div>
                <label for="">Box Number:</label>
                <input type="text" name="rental-add-box-number" id="rental-add-box-number"  required> 
            </div>
            <div>
                <label for="">Box Size:</label>
                <select name="" id="rental-add-box-size" required>
                    <option value="">Size option -</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>  
                </select>
            </div>
            <div>
                <label for="">Width (cm):</label>
                <input type="text" name="rental-add-box-width" id="rental-add-box-width"   placeholder="cm" required>
            </div>
            <div>               
                <label for="">Length (cm):</label>
                <input type="text" name="rental-add-box-length" id="rental-add-box-length"  placeholder="cm" required>
            </div>
            <div>
                <label for="">Rental Fee:</label>
                <input type="text" name="rental-add-box-rental-fee" id="rental-add-box-rental-fee"  required>
            </div>
            <div>
                <label for="">Quantity:</label>
                <input type="text" name="rental-add-box-quantity" id="rental-add-box-quantity"  required>          
            </div>
            <div>
                <label for="">Status:</label>
                <select name="" id="rental-add-box-status" required>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>        
            <input type="submit" id="add-box-rental-save-button">
        </form>
        <button id="add-box-rental-cancel-button">Cancel</button>      
    </div>
</div>
<!---| FOR EDITING RENTER DETAILS |-->
<div class="rental-edit-renter-modal-container">
    <div class="rental-edit-renter-modal">
        <h2>Editing Renter </h2>
            <input type="text" name="rental-edit-box-id" id="rental-edit-renter-id" hidden>
            <div>
                <label for="">Renter Name:</label>
                <input type="text" name="rental-edit-box-number" id="rental-renter-name"  required> 
            </div>   
            <div>
                <label for="">Contact Number:</label>
                <input type="text" name="rental-edit-box-number" id="rental-edit-contact-number"  required> 
            </div>        
            <div class="edit-renter-button-container">
                <button id="edit-renter-save-button">Save</button>      
                <button id="edit-renter-cancel-button">Cancel</button>  
            </div>                              
    </div>
 </div>
 
<!-- | EDIT RENTAL BOX MODAL |-->
 <div class="rental-edit-box-rental-modal-container">
    <div class="rental-edit-box-rental-modal">
        <h2>Editing Rental Box</h2>
            <input type="text" name="rental-edit-box-id" id="rental-edit-box-id" hidden>
            <div>
                <label for="">Box Number:</label>
                <input type="text" name="rental-edit-box-number" id="rental-edit-box-number"  required> 
            </div>
            <div>
                <label for="">Box Size:</label>
                <select name="" id="rental-edit-box-size" required>
                    <option value="">Size option -</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>  
                </select>
            </div>
            <div>
                <label for="">Width (cm):</label>
                <input type="text" name="rental-edit-box-width" id="rental-edit-box-width"   placeholder="cm" required>
            </div>
            <div>               
                <label for="">Length (cm):</label>
                <input type="text" name="rental-edit-box-length" id="rental-edit-box-length"  placeholder="cm" required>
            </div>
            <div>
                <label for="">Rental Fee:</label>
                <input type="text" name="rental-edit-box-rental-fee" id="rental-edit-box-rental-fee"  required>
            </div>
            <div>
                <label for="">Quantity:</label>
                <input type="text" name="rental-edit-box-quantity" id="rental-edit-box-quantity"  required>          
            </div>
            <div>
                <label for="">Status:</label>
                <select name="" id="rental-edit-box-status" required>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>
            <div class="edit-rental-box-button-container">
                <button id="edit-box-rental-save-button">Save</button>      
                <button id="edit-box-rental-cancel-button">Cancel</button>  
            </div>                              
    </div>
 </div>

<!-- | DELATION CONFIRMATION FOR RENTAL BOX |-->
<div class="delete-box-modal-container">
    <div class="delete-box-modal">
        <p>Are you sure you want to delete this box?</p>
        <span id="delete-box-number"></span>
        <div class="box-delete-yes-and-no-button">
            <button id="delete-box-yes-button">Yes</button>
            <button id="delete-box-no-button">No</button>
        </div>

    </div>
</div>
<!-- | FOR PRINTING RECEIPT FOR TENTAL BOX |-->
 <div class="print-receipt-modal-container">
    <div class="print-receipt-modal">
        <h2>Print Receipt?</h2>
        <div class="print-receipt-yes-and-no-button">
            <button id="print-receipt-yes-button">Print</button>
            <button id="print-receipt-no-button">No</button>
        </div>

    </div>
 </div>


 <!-- | DELATION CONFIRMATION FOR RENTAL |-->
<div class="delete-rental-modal-container">
    <div class="delete-rental-modal">
        <p>Are you sure you want to delete Rental?</p>
        <span id="delete-rental-id"></span>
        <div class="rental-delete-yes-and-no-button">
            <button id="delete-rental-yes-button">Yes</button>
            <button id="delete-rental-no-button">No</button>
        </div>

    </div>
</div>
