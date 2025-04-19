<!-- | ALL SALES CONTENT ONLY HERE |-->

<?php 
session_start();

if (!isset($_SESSION['user'])) {
    // if not login, go to login page
    header('Location: login.php');
    exit;
}

    $page ='pos'; //ASSIGNS THE NAME OF THE PAGE. THIS PAGE IS NAMED 'SALES' AND IS USED IN THE HEADER.PHP FILE.
    require '../includes/header.php'; //REQUIRES THE HEADER.PHP, FOR YOU CAN APPLY THE CSS,SCRIPT,SIDEBAR, AND TOPNAV ON THIS PAGE.
?>


<main class="pos-main-content-container"><!-- | THE STYLES FOR THIS CONTAINER ARE DEFINED IN GLOBAL.CSS TO STANDARDIZE THE STYLE OF THE MAIN CONTAINER ACROSS ALL PAGES |-->
    <!-- | your code here |-->

    <div class="pos-main-container">
        <h1>Point Of Sale</h1>

        <!--| FOR SHOPPING CART AND RECIEPT PREVIEW |-->
        <div class="pos-sub-container">
            <!--| SHOPPING CART |-->
            <div class="shopping-cart-container">
                <h4>Shopping Cart:</h4>
                <div class="shopping-cart-content-container">
                    <div class="select-product-container">
                        <button id="pos-select-product-button">Select Product</button>
                        <button id="pos-scan-product-button">Scan Product</button>
                    </div>
                    <div class="pos-shopping-cart-table-container">
                        <table id="pos-shopping-cart-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>                          
                                </tr>
                            </thead>
                            <tbody>
                                <!-- JS inserts rows here -->
                            </tbody>                                                                                                               
                        </table>
                    </div>
                    <div class="pos-shopping-cart-subtotal-container" >
                        <label for="">Sub Total:</label>
                        <span id="pos-shopping-sub-total"></span>
                    </div>
                    <div class="pos-info-buttons-container">
                        <div>
                            <label for="">Payment Method:</label>
                            <select id="select-payment">
                                <option value="">- Select Payment -</option>
                                <option value="">Cash</option>
                            </select>
                        </div>
                        <div>
                            <label for="">Amount Recieved:</label>
                            <input type="text" id="pos-input-amount-recieved">
                        </div>
                        <div>
                            <label for="">Change:</label>
                            <span id="pos-shopping-change"></span>
                        </div>
                    </div>
                    <div class="pos-transaction-process-and-cancel-button-container">
                        <button>Process Payment</button>
                        <button>Cancel Transaction</button>
                    </div>                    
                </div>               
            </div>
             <!--| RECIEPT PREVIEW |-->
            <div class="receipt-preview-container">
                <h4>Receipt Preview:</h4>
                <div class="receipt-preview-content-container">
                    <div class="receipt-preview-date-container">                       
                        <span>December 12 2023</span>
                    </div>
                    <h4 id="h4-store-name">General's Space Rent</h4>
                    <div class="transaction-details-container">
                        <div class="pos-product-sales-receipt-container">
                            <div class="pos-product-total-sales-container">
                                <label for="">Total Items:</label>
                                <span id="pos-receipt-total-items"></span>                             
                            </div>                          
                            <table id="pos-product-sales-receipt-table"><tbody></tbody></table>
                        </div>
                        <div>
                            <label for="">Total:</label>
                            <span id="pos-receiptt-total-sales-amount"></span>
                        </div>
                        <div>
                            <label for="">Payment Method:</label>
                            <span>Cash</span>
                        </div>
                        <div>
                            <label for="">Amount Recieved:</label>
                            <span id="pos-receipt-amount-received"></span>
                        </div>
                        <div>
                            <label for="">Change:</label>
                            <span id="pos-receipt-change-amount"></span>
                        </div>
                    </div>
                    <div class="customer-information-container">
                        <h5>Custormer Informaion: (optional)</h5>
                        <div class="name-container">
                            <label for="">Name:</label>
                            <input type="text">
                        </div>
                        <div class="contact-number-container">
                            <label for="">Contact Number:</label>
                            <input type="text">
                        </div>                    
                    </div>                  
                                    
                </div>                
            </div>
        </div>
    </div>
    <div class="pos-product-selection-modal-container">
        <div class="pos-product-selection-container">
            <div class="pos-product-selection-header-container">
                <h4>Product Selection</h4>
                <span class="exit-icon" id="pos-product-selection-exit-button">&times;</span>
            </div>          
            <div class="pos-product-selection-content-container">
                <div class="pos-product-selection-search-container">
                    <form id="search-form">
                        <input type="text" placeholder="Search" id="search-input">
                        <button type="submit" name="submit" id="search-submit-button">search</button>
                    </form>
                </div>  
                <div class="pos-product-table-container">
                    <table id="pos-product-selection-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Barcode</th>
                                <th>Price</th>
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

</main>