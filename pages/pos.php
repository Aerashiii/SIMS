<!-- | ALL SALES CONTENT ONLY HERE |-->
<!-- pos.php -->
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
                        <input 
                            type="text" 
                            id="pos-barcode-scanner-input" 
                            placeholder="Scan barcode..." 
                            autofocus 
                            style="position:absolute; left:-9999px;" 
                        />
                       
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
                            <input type="text" id="pos-input-amount-recieved" required>
                        </div>
                        <div>
                            <label for="">Change:</label>
                            <span id="pos-shopping-change"></span>
                        </div>
                    </div>
                    <div class="pos-transaction-process-and-cancel-button-container">
                        <button id="pos-transaction-process-button">Process Payment</button>
                        <button id="pos-transaction-cancel-button">Cancel Transaction</button>
                    </div>                    
                </div>               
            </div>
             <!--| RECIEPT PREVIEW |-->
            <div class="receipt-preview-container">
                <h4>Receipt Preview:</h4>
                <div class="receipt-preview-content-container">

                    <div class="pos-receipt-datetime-container">
                        <p><?php echo date(' M j, Y |  h:i A'); ?></p>
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
                            <label for="" class="pos-receipt-total-label">Total:</label>
                            <span id="pos-receipt-total-sales-amount"></span>
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
                            <input type="text" id="pos-customer-name-input" required>
                        </div>
                        <div class="contact-number-container">
                            <label for="">Contact Number:</label>
                            <input type="text" id="pos-customer-contact-number-input" required>
                        </div>                    
                    </div>                  
                                    
                </div>                
            </div>
        </div>
    </div>
<!---- | MODAL FOR SELECTING PRODUCT |-->
    <div class="pos-product-selection-modal-container">
        <div class="pos-product-selection-container">
            <div class="pos-product-selection-header-container">
                <h4>Product Selection</h4>
                <span class="exit-icon" id="pos-product-selection-exit-button">&times;</span>
            </div>          
            <div class="pos-product-selection-content-container">
                <div class="pos-product-selection-search-container">                 
                        <input type="text" placeholder="Search" id="pos-product-selection-search-input">
                        <button type="submit" name="submit" id="pos-product-selection-search-submit-button">search</button>                 
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
<!-- | MODAL FOR PROCESSING PAYMENT |-->
<!-- | THIS MODAL IS FOR PROCESSING PAYMENT. IT WILL SHOW UP WHEN THE USER CLICKS THE PROCESS PAYMENT BUTTON |-->
    <div class="pos-sales-process-modal-container">
        <div class="pos-sales-process-container">
            <div class="pos-sales-process-header-container">
                <h4>Process Payment</h4>
                <span class="exit-icon" id="pos-sales-process-exit-button">&times;</span>
            </div>  
            <div class="pos-sales-process-content-container">
                <div class="pos-sales-process-table-container">
                    <table id="pos-sales-process-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Barcode</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            <!-- JS inserts rows here -->   
                        </tbody>                
                    </table>
                </div> 
                <div class="pos-sales-process-subtotal-container" >
                    <label for="">Sub Total:</label>
                    <span id="pos-sales-sub-total"></span>
                </div> 
                <div class="pos-sales-process-cash-amount-container" >
                    <label for="">Cash Amount:</label>
                    <span id="pos-sale-cash-amount"></span>
                </div>
                <div class="pos-sales-process-total-change-container" >
                    <label for="">Change:</label>
                    <span id="pos-sale-change-amount"></span>
                </div>
                <div class="pos-sales-process-buttons-container">
                    <button id="pos-sales-process-confirm-button">Confirm Payment</button>
                    <button id="pos-sales-process-cancel-button">Cancel Payment</button>
                </div> 
            </div>            
        </div>
    </div>

<!-- | MODAL FOR SUCCESSFUL TRANSACTION |-->
<!-- | THIS MODAL IS FOR SUCCESSFUL TRANSACTION. IT WILL SHOW UP WHEN THE USER CLICKS THE PROCESS PAYMENT BUTTON |-->
        <div class="pos-sales-success-modal-container">
            <div class="pos-sales-success-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle feather-40" id="pos-transact-success-icon">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <h4>Transaction Success</h4>
                <p>Transaction has been successfully processed.</p>
                <div class="pos-sales-success-buttons-container">
                    <button id="pos-transact-print-receipt-button">Print receipt</button>
                    <button id="pos-transact-next-order-button">Next Order</button>
               </div>
                
            </div>
        </div>



</main>