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
<style>
    #rental-button{
        background-color: #B2CF9B;
        color: white;
    }
</style>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
 <!-- | Rental Header|-->  
  <div class="rental-management-header-container">
    <h1>Rental Management</h1>
    <a href="rental-add-rental.php"><button id="add-rental-button"><img src="../assets/images/icons/add-rental.png" alt="" id="add-rental-icon">Add Rental</button></a>
  </div>
    
  <div class="rental-management-content-container">
    <!--|Switch content |-->  
        <div class="rental-boxes-switch-content-buttons-container">
            <a href="rental.php"><button id="rental-button">Rental</button></a>
            <a href="rental-renter-list.php"><button id="renter-list-button" class="active">Renter List</button></a>
            <a href="rental-rental-box.php"><button id="rental-box-button">Rental Box</button></a>
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


     

</main>
 


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
