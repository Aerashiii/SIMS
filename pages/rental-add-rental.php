<!-- | ALL RENTAL-BOXES CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}


    $page ='rental-add-rental'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'RENTAL-BOXES' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
 <!-- | Rental Header|-->  
  <div class="rental-management-header-container">
    <h1>Rental Management</h1>
    <a href="rental.php"><button id="add-rental-back-button">Back</button></a>
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
                <div class="addRental-selection-search-container">                 
                    <input type="text" placeholder="Search" id="rentalbox-selection-search-input">
                    <button type="submit" name="submit" id="rentalbox-selection-search-submit-button">searchss</button>                 
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
