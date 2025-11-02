<!-- | ALL RENTAL-BOXES CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}


    $page ='rental-add-rental-box'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'RENTAL-BOXES' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>

<main class="main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
 <!-- | Rental Header|-->  
  <div class="rental-management-header-container">
    <h1>Rental Management</h1>
    <a href="rental-rental-box.php"><button id="add-rental-back-button">Back</button></a>
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
                   
                </select>
            </div>        
            <input type="submit" id="add-box-rental-save-button">
        </form>
        <button id="add-box-rental-cancel-button">Cancel</button>      
    </div>
</div>

 <!-- Toast container -->
      <div id="toast" aria-live="polite"></div>


</main>
 




