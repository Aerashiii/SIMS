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

 <div class="rental-header-container">
        <h1>Rental Management</h1>
        <div class="search-container">
            <input type="text" placeholder="Search">
            <button>Search</button>
        </div>
        <button id="add-rental-button">Add New Rental</button>
    </div>

 <!--|Switch content |-->  
 <div class="rental-boxes-switch-content-buttons-container">
        <button id="renter-list-button" class="active">Renter List</button>
        <button id="rental-box-button">Rental Box</button>
        <button id="rental-button">Rental Button</button>
        <button id="billing-button">Billing</button>
        <button id="rental-ledger-button">Rental Ledger</button>
</div>

     <!---------------| FOR RENTER LIST------------------>
     <div class="rental-boxes-content-container active" id="renterlist-content-container">
                <div class="renter-list-container">
                    <div class="renter-list-header-container">
                        <h3>Renter list:</h3> 
                    </div>   
                    <table id="renter-list-table">
                        <tr>
                            <th>Renter Name</th>
                            <th>Contact Number</th>
                            <th>
                                <span id="renter-list-action-text">Action</span>
                                <button id="renter-list-delete-active-checkbox-button">Delete</button>
                            </th>
                        </tr>
                    </table>
                </div>
     </div>

      <!---------------| FOR RENTAL BOX INFORMATION |------------------>
      <div class="rental-boxes-content-container" id="rentalbox-content-container">
                <div class="rental-box-content-container">
                    <div class="rental-box-header-container">
                        <h3>Rental Box Information:</h3>
                    </div>   
                    <table id="rental-box-table">
                        <tr>
                            <th>Box Number</th>
                            <th>Box Size</th>
                            <th>Rental Fee</th>
                            <th>Status</th>
                            <th>
                                <span id="rental-box-action-text">Action</span>
                                <button id="rental-box-delete-active-checkbox-button">Delete</button>
                            </th>
                        </tr>
                    </table>
                </div>
      </div>

      <!---------------| FOR RENTAL |------------------>
      <div class="rental-boxes-content-container" id="rentalbox-content-container">
                <div class="rental-content-container">
                    <div class="rental-header-container">
                        <h3>Rental:</h3>
                    </div>   
                    <table id="rental-table">
                        <tr>
                            <th>Box Number</th>
                            <th>Renter Name</th>
                            <th>Contact Number</th>
                            <th>Rental Start Date</th>
                            <th>Rental End Date</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>
                                <span id="rental-action-text">Action</span>
                                <button id="rental-delete-active-checkbox-button">Delete</button>
                            </th>
                        </tr>
                    </table>
                </div>
      </div>

      <!---------------| FOR Billing |------------------>
      <div class="rental-boxes-content-container" id="rentalbox-content-container">
                <div class="billing-content-container">
                    <div class="billing-header-container">
                        <h3>Billing:</h3>
                    </div>   
                    <table id="billing-table">
                        <tr>
                            <th>Box Number</th>
                            <th>Renter Name</th>
                            <th>Invoice Number</th>
                            <th>Billing Date</th>
                            <th>Ammount Due</th>
                            <th>Outstanding Amount</th>
                            <th>Payment Date</th>
                            <th>
                                <span id="billing-action-text">Action</span>
                                <button id="generate-invoice-active-checkbox-button">Generate Invoice</button>
                                <button id="apply-payment-active-checkbox-button">Apply Payment</button>
                            </th>
                        </tr>
                    </table>
                </div>
      </div>

    <!---------------| FOR Billing |------------------>
    <div class="rental-boxes-content-container" id="rentalbox-content-container">
        <div class="rental-ledger-content-container">
                <div class="rental-ledger-header-container">
                     <h3>Rental Ledger:</h3>
                </div>   
                    <table id="rental-ledger-table">
                        <tr>
                            <th>Box Number</th>
                            <th>Transaction Date</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>
                                <span id="rental-ledger-action-text">Action</span>
                                <button id="billing-delete-active-checkbox-button">Delete</button>
                            </th>
                        </tr>
                    </table>
        </div>
    </div>

<!--------| ADD NEW RENTAL | --------------->
<!--| #7 |-->  
<div class="add-rental-modal-container">
    <div class="add-rental-form-container">
        <form action="" id="add-rental-form">
            <h3>Add Renter</h3>
            <div class="form-group-container">
                <label>Box Number:</label>
                <input type="text" id="add-rental-box-number"required>
            </div>
            <div class="form-group-container">
                <label>Box Size:</label>
                <select name="" id="add-rental-box-size" required>
                    <option value="">- Select Brand -</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Rental Fee:</label>
                <input type="text" id="add-rental-fee"required>
                </select>
            </div>
            <div class="form-group-container">
                <label>Rental Start Date:</label>
                <input type="text" id="add-rental-start-date"required>
            </div>
            <div class="form-group-container">
            <label>Rental End Date:</label>
            <input type="text" id="add-rental-end-date"required>
            </div>
            <div class="form-group-container">
                <h2>Customer Information:</h2 id="add-rental-customer-information">
            </div>
            <div class="form-group-container">
                <label>Name:</label>
                <input type="text" id="add-rental-name" required>
            </div>
            <div class="form-group-container">
                <label>Contact Number:</label>
                <input type="text"id="add-rental-contact-number" required>
            </div>
            <div class="form-group-container">
                <label>Status:</label>
                <select name="" id="add-rental-status" required>
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>
            <div class="form-group-container">
                <label>Payment Status:</label>
                <select name="" id="add-rental-payent-status" required>
                    <option value="paid">paid</option>
                    <option value="canceled">canceled</option>
                    <option value="pending">pending</option>
                </select>
            </div>

            <input type="submit" id="add-rental-submit-button">
        </form>
        <button id="add-rental-cancel-button">Cancel</button>

    </div>

</div>