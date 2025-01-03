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
                            <tr>
                                <th>Product Name</th>
                                <th>Barcode</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>                          
                            </tr>
                            <tr>
                                <td>Dress</td>
                                <td>123</td>
                                <td>324234</td>
                                <td>23</td>
                                <td>23452354</td>
                                <td>
                                    <button>Remove</button>
                                </td>
                            </tr>                                                                                   
                        </table>
                    </div>
                    <div class="pos-shopping-cart-subtotal-container" >
                        <label for="">Sub Total:</label>
                        <span>12323</span>
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
                            <input type="text" id="input-amount-recieved">
                        </div>
                        <div>
                            <label for="">Change:</label>
                            <span id="change">12312</span>
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
                        <div>
                            <label for="">Total Items:</label>
                            <span>12</span>
                        </div>
                        <div>
                            <label for="">Total:</label>
                            <span>123213</span>
                        </div>
                        <div>
                            <label for="">Payment Method:</label>
                            <span>Cash</span>
                        </div>
                        <div>
                            <label for="">Amount Recieved:</label>
                            <span>500</span>
                        </div>
                        <div>
                            <label for="">Change:</label>
                            <span>23</span>
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
                   
                    <button id="receipt-preview-print-button">Print Receipt</button>

                    
                    

                </div>
                
            </div>
        </div>

        
        





    </div>









</main>