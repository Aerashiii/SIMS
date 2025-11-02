<!-- | ALL RENTAL-BOXES CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}


    $page ='rental-rental-box'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'RENTAL-BOXES' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>
<style>
    #rental-box-button{
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

       

        <!---------------| FOR RENTAL BOX INFORMATION |------------------>
        <div class="rental-boxes-content-container" id="rentalbox-content-container">
                    <div class="rental-box-content-container">
                        <div class="rental-box-header-container">
                            <h3>Rental Box Information:</h3>
                            <div class="rental-search-container">         
                                <input type="text" placeholder="Search" class="rental-search-input" id="rental-box-search-input">
                                <button type="submit" name="submit" class="rental-search-submit-button" id="rental-box-search-submit-button">search</button>
                            </div>   
                            <a href="rental-add-rental-box.php"><button id="rental-add-rental-box-button">Add Rental Box</button></a>
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
       
        </div>
    </div> 

    <!-- Toast container -->
      <div id="toast" aria-live="polite"></div>

</main>

 
<!-- | EDIT RENTAL BOX MODAL |-->
 <div class="rental-edit-box-rental-modal-container" id="editBoxModalContainer">
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

